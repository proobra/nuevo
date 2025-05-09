# Guía Git para Trabajo en Equipo – Proobra

Esta guía resume los pasos recomendados para trabajar en equipo sobre este repositorio de forma segura y sin conflictos.

---

## 📥 Clonar el repositorio (primera vez)

```bash
git clone https://github.com/proobra/nuevo.git
```

---

## 🔄 Antes de trabajar – Actualizar tu copia local

Siempre hacé un `pull` antes de comenzar a modificar archivos:

```bash
git pull origin main
```

---

## 💾 Guardar tus cambios

Después de trabajar en tus archivos:

```bash
git add .
git commit -m "Describí brevemente qué cambiaste"
```

---

## 🚀 Subir tus cambios

Después de hacer commit:

```bash
git push
```

---

## ⚠️ En caso de conflictos

Si al hacer `git push` te aparece un error:

```bash
git pull origin main --allow-unrelated-histories
# o
git pull origin main
```

Resolvé el conflicto, hacé `git add` al archivo corregido y:

```bash
git commit -m "Conflicto resuelto"
git push
```

---

## 📌 Buenas prácticas

- Hacé `pull` siempre antes de modificar.
- Usá mensajes de commit claros.
- Consultá con tu compañero si hay dudas antes de subir archivos grandes o cambios masivos.

---

Proobra — Gestión colaborativa de desarrollo ✍️