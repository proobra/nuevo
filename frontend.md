# Guía para compilar assets con Vite en Laravel (Proobra)

Este archivo explica cómo compilar correctamente los archivos CSS y JS cuando se realizan cambios en el frontend.

---

## 📦 Paso 1: Instalar dependencias (una sola vez)

Si es la primera vez que trabajás en el proyecto o recién clonaste el repositorio:

```bash
npm install
```

---

## ⚙️ Paso 2: Compilar para producción

Cada vez que se cambien archivos en `resources/js/` o `resources/css/`, debés ejecutar:

```bash
npm run build
```

Esto genera la carpeta `public/build` con los archivos necesarios y el `manifest.json`.

---

## 🚧 Modo desarrollo (opcional)

Si querés trabajar con recarga automática mientras editás, ejecutá:

```bash
npm run dev
```

---

## ❗ Error común

Si al cargar la web aparece este error:

```
Illuminate\Foundation\ViteManifestNotFoundException: Vite manifest not found at: public/build/manifest.json
```

Solución: Ejecutar:

```bash
npm install
npm run build
```

---

## 📝 Notas

- Asegurate de tener Node.js y NPM instalados.
- Este proyecto usa Vite para compilar los assets modernos de Laravel.

---

Proobra — Documentación técnica ✍️