---
name: shadcn_ui
description: Panduan instalasi, inisialisasi, dan penambahan komponen shadcn/ui menggunakan CLI untuk proyek web React/Next.js.
---

# Panduan Integrasi dan Penggunaan shadcn/ui

Gunakan panduan ini ketika bekerja dengan komponen **shadcn/ui** pada proyek React, Next.js, atau Vite yang menggunakan Tailwind CSS.

## 1. Inisialisasi Proyek (Initialization)

Sebelum menambahkan komponen, inisialisasi shadcn/ui pada direktori root proyek menggunakan perintah:

```bash
npx shadcn@latest init
```

Perintah ini akan menanyakan preferensi proyek dan menghasilkan file [components.json](file:///components.json) serta file helper utilitas `cn` (biasanya di `lib/utils.ts`).

### Struktur `components.json` yang Direkomendasikan:
```json
{
  "$schema": "https://ui.shadcn.com/schema.json",
  "style": "new-york",
  "rsc": true,
  "tsx": true,
  "tailwind": {
    "config": "tailwind.config.js",
    "css": "app/globals.css",
    "baseColor": "zinc",
    "cssVariables": true,
    "prefix": ""
  },
  "aliases": {
    "components": "@/components",
    "utils": "@/lib/utils",
    "ui": "@/components/ui",
    "lib": "@/lib",
    "hooks": "@/hooks"
  }
}
```

## 2. Mengelola Komponen via CLI

Selalu gunakan CLI resmi shadcn untuk menambah atau memperbarui komponen, hindari membuat file UI secara manual kecuali untuk custom wrapper.

### Menambahkan Komponen Baru
Gunakan perintah berikut untuk mengunduh komponen langsung ke dalam folder `components/ui/`:
```bash
npx shadcn@latest add [component-name]
```
*Contoh:*
* Menambahkan Button: `npx shadcn@latest add button`
* Menambahkan Dialog & Form: `npx shadcn@latest add dialog form`

### Memeriksa Perubahan Komponen
Untuk melihat perbedaan kode komponen lokal dengan kode registry resmi:
```bash
npx shadcn@latest diff [component-name]
```

## 3. Praktik Terbaik Pemrograman (Coding Best Practices)

### Penggabungan Kelas Tailwind (`cn` helper)
Selalu gunakan fungsi `cn(...)` yang diimpor dari `@/lib/utils` ketika ingin menggabungkan kelas CSS bawaan dengan properti kelas dinamis (`className` prop) dari luar komponen:
```tsx
import { cn } from "@/lib/utils"

export function CustomButton({ className, ...props }) {
  return (
    <button
      className={cn("bg-primary text-primary-foreground px-4 py-2 rounded", className)}
      {...props}
    />
  )
}
```

### Aksesibilitas (Accessibility)
Beberapa komponen shadcn/ui yang memanfaatkan Radix UI (seperti Dialog, Sheet, AlertDialog) membutuhkan elemen judul (`DialogTitle` / `SheetTitle`) agar ramah pembaca layar (screen reader). Selalu sertakan elemen tersebut di dalam konten dialog:
```tsx
import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog"

<Dialog>
  <DialogContent>
    <DialogHeader>
      <DialogTitle>Judul Dialog</DialogTitle>
    </DialogHeader>
    {/* Konten lainnya */}
  </DialogContent>
</Dialog>
```

### Tema Berwarna (Theming)
Gunakan variabel CSS tema (seperti `bg-background`, `text-foreground`, `border-input`) ketimbang menuliskan warna absolut (`bg-white`, `text-gray-900`) agar kompatibilitas Mode Gelap (Dark Mode) tetap terjaga secara otomatis.
