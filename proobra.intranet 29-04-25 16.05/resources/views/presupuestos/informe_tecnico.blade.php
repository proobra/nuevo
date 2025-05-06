@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="mb-4 text-center">Informe Técnico de Presupuesto</h2>

    {{-- Datos generales --}}
    <div class="card mb-4 p-3">
        <h4>Datos del Presupuesto</h4>
        <p><strong>Cliente:</strong> {{ $presupuesto->cliente }}</p>
        <p><strong>Obra:</strong> {{ $presupuesto->direccion }}</p>
        <p><strong>Superficie:</strong> {{ number_format($presupuesto->superficie, 2, ',', '.') }} m²</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($presupuesto->fecha)->format('d/m/Y') }}</p>
    </div>

    {{-- Tabla Detalle --}}
    <div class="card p-3 mb-4">
        <h4>Detalle General</h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Rubro</th>
                        <th>Unidad</th>
                        <th>M2</th>
                        <th>M.O.</th>
                        <th>Materiales</th>
                        <th>$/M2</th>
                        <th>Utilidad</th>
                        <th>Total General</th>
                        <th>IVA (22%)</th>
                        <th>BPS (%)</th>
                        <th>BPS ($)</th>
                        <th>Total Final</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sumaManoDeObra = 0;
                        $sumaMateriales = 0;
                        $sumaCostoPorM2 = 0; // nuevo
                        $sumaUtilidad = 0;
                        $sumaTotalGeneral = 0;
                        $sumaIVA = 0;
                        $sumaBPS = 0;
                        $sumaTotalFinal = 0;
                    @endphp
                    
                    @foreach($presupuesto->replanteos as $tarea)
                        @php
                            $m2 = $tarea->m2 ?? 0;
                    
                            // Materiales
                            $materialesTarea = $presupuesto->materiales->where('orden', $tarea->orden);
                            $subtotalMateriales = $materialesTarea->sum(function($mat) {
                                return ($mat->cantidad_unidades ?? 0) * ($mat->costo_unitario ?? 0);
                            });
                    
                            // Mano de Obra
                            $manoObraTarea = $presupuesto->manoDeObra->where('orden', $tarea->orden);
                            $subtotalManoDeObra = $manoObraTarea->sum(function($mo) {
                                return ($mo->cantidad ?? 0) * ($mo->dias ?? 0) * ($mo->valor_jornal ?? 0);
                            });
                    
                            // Costo por m²
                            $costoPorM2 = ($subtotalManoDeObra + $subtotalMateriales) / max(1, $m2);
                    
                            $subtotalGastosFijos = 0; // no usamos
                            $utilidad = ($presupuesto->utilidad ?? 0) * ($subtotalManoDeObra / max(1, $presupuesto->manoDeObra->sum(function($mo) {
                                return ($mo->cantidad ?? 0) * ($mo->dias ?? 0) * ($mo->valor_jornal ?? 0);
                            })));
                    
                            $subtotalGeneral = $subtotalManoDeObra + $subtotalMateriales + $subtotalGastosFijos + $utilidad;
                            $iva = $subtotalGeneral * 0.22;
                    
                            $laudos = \App\Models\LaudoOperario::all();
                            $totalBaseLaudo = $manoObraTarea->sum(function($mo) use ($laudos) {
                                $laudoBase = $laudos->firstWhere('categoria', $mo->categoria)?->laudo_base ?? 0;
                                return ($mo->cantidad ?? 0) * ($mo->dias ?? 0) * $laudoBase;
                            });
                    
                            $bpsPorcentaje = $presupuesto->bps_porcentaje ?? 0;
                            $bpsMonto = ($totalBaseLaudo * $bpsPorcentaje) / 100;
                    
                            $totalFila = $subtotalGeneral + $iva + $bpsMonto;
                    
                            // Sumas para el tfoot
                            $sumaManoDeObra += $subtotalManoDeObra;
                            $sumaMateriales += $subtotalMateriales;
                            $sumaCostoPorM2 += $costoPorM2;
                            $sumaUtilidad += $utilidad;
                            $sumaTotalGeneral += $subtotalGeneral;
                            $sumaIVA += $iva;
                            $sumaBPS += $bpsMonto;
                            $sumaTotalFinal += $totalFila;
                        @endphp
                    
                        <tr>
                            <td>{{ $tarea->descripcion_tarea }}</td>
                            <td>m²</td>
                            <td>{{ number_format($m2, 2, ',', '.') }}</td>
                            <td>{{ number_format($subtotalManoDeObra, 2, ',', '.') }}</td>
                            <td>{{ number_format($subtotalMateriales, 2, ',', '.') }}</td>
                            <td>{{ number_format($costoPorM2, 2, ',', '.') }}</td> <!-- 🛠 -->
                            <td>{{ number_format($utilidad, 2, ',', '.') }}</td>
                            <td>{{ number_format($subtotalGeneral, 2, ',', '.') }}</td>
                            <td>{{ number_format($iva, 2, ',', '.') }}</td>
                            <td>{{ number_format($bpsPorcentaje, 2, ',', '.') }}%</td>
                            <td>{{ number_format($bpsMonto, 2, ',', '.') }}</td>
                            <td><strong>{{ number_format($totalFila, 2, ',', '.') }}</strong></td>
                        </tr>
                    @endforeach
                    </tbody>
                    
                <tfoot>
                    <tfoot>
                        <tr class="table-secondary fw-bold">
                            <td colspan="3" class="text-end">Totales:</td>
                            <td>{{ number_format($sumaManoDeObra, 2, ',', '.') }}</td>
                            <td>{{ number_format($sumaMateriales, 2, ',', '.') }}</td>
                            <td>{{ number_format($sumaCostoPorM2, 2, ',', '.') }}</td> <!-- ✅ Sumamos $/m² -->
                            <td>{{ number_format($sumaUtilidad, 2, ',', '.') }}</td>
                            <td>{{ number_format($sumaTotalGeneral, 2, ',', '.') }}</td>
                            <td>{{ number_format($sumaIVA, 2, ',', '.') }}</td>
                            <td>{{ number_format($bpsPorcentaje ?? 0, 2, ',', '.') }}%</td> <!-- ✅ Mostramos BPS % -->
                            <td>{{ number_format($sumaBPS, 2, ',', '.') }}</td> <!-- ✅ Sumamos BPS ($) -->
                            <td>{{ number_format($sumaTotalFinal, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    
                </tfoot>
                
            </table>
        </div>
    </div>

    {{-- Botón de volver --}}
    <div class="text-center mt-4">
        <a href="{{ route('presupuestos.edit', $presupuesto->id) }}" class="btn btn-secondary">
            ← Volver al Presupuesto
        </a>
    </div>

</div>
@endsection
