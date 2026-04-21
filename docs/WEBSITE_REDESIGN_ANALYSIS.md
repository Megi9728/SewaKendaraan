# 📊 WEB REDESIGN ANALYSIS - JATARA

**Project**: SewaKendaraan (JATARA - Jasa Transportasi Rental & Armada)  
**Current Design**: Uber Design System  
**Target Design**: AIRBNB + JATARA Colors  
**Date**: April 16, 2026  
**Status**: Analysis Phase

---

## 🎯 OVERVIEW

### **Current State**

- Framework: Laravel Blade Templates
- Current Design System: Uber (Black & White)
- Current Colors:
    - Primary: `#000000` (Black)
    - Secondary: `#ffffff` (White)
    - Accent: `#efefef` (Light Gray)
    - Text: `#4b4b4b` (Dark Gray)

### **Target State**

- Design System: AIRBNB (Marketplace principles)
- Target Colors:
    - Primary: `#0A174E` (Oxford Blue)
    - Secondary: `#EBEBDF` (Pale Gray)
    - Accent: `#F5D042` (Maize)
    - Text: `#0A174E` (Oxford Blue)

---

## 📱 PAGES INVENTORY

### **Public Pages (Non-authenticated)**

| Page               | Current            | File                       | Status            |
| ------------------ | ------------------ | -------------------------- | ----------------- |
| **Home**           | Uber hero section  | `home.blade.php`           | ⚠️ Needs redesign |
| **Browse**         | Uber filter + grid | `browse.blade.php`         | ⚠️ Needs redesign |
| **Vehicle Detail** | Uber detail view   | `vehicle-detail.blade.php` | ⚠️ Needs redesign |
| **How It Works**   | Basic info page    | `how-it-works.blade.php`   | 🟡 Minor tweaks   |
| **Help**           | FAQ section        | `help.blade.php`           | 🟡 Minor tweaks   |
| **Login**          | Auth form          | `auth/login.blade.php`     | ⚠️ Needs redesign |
| **Register**       | Auth form          | `auth/register.blade.php`  | ⚠️ Needs redesign |

### **User Pages (Authenticated)**

| Page                | Current      | File                     | Status            |
| ------------------- | ------------ | ------------------------ | ----------------- |
| **Checkout**        | Uber form    | `checkout.blade.php`     | ⚠️ High priority  |
| **Booking History** | Uber list    | `user/history.blade.php` | ⚠️ Needs redesign |
| **Receipt**         | Uber receipt | `user/receipt.blade.php` | 🟡 Minor tweaks   |
| **User Profile**    | Uber profile | `user/profile.blade.php` | 🟡 Minor tweaks   |

### **Admin Pages**

| Page                    | Current      | File                             | Status            |
| ----------------------- | ------------ | -------------------------------- | ----------------- |
| **Admin Dashboard**     | Stats cards  | `admin/dashboard.blade.php`      | ⚠️ Needs redesign |
| **Bookings Management** | Admin list   | `admin/bookings/index.blade.php` | ⚠️ Needs redesign |
| **Vehicles CRUD**       | Admin table  | `admin/vehicles/index.blade.php` | ⚠️ Needs redesign |
| **Vehicle Units**       | Fleet view   | `admin/vehicles/units.blade.php` | ⚠️ Needs redesign |
| **Drivers Management**  | Admin list   | `admin/drivers/index.blade.php`  | ⚠️ Needs redesign |
| **Admin Profile**       | Uber profile | `admin/profile.blade.php`        | 🟡 Minor tweaks   |

### **Mitra Pages**

| Page                | Current     | File                             | Status            |
| ------------------- | ----------- | -------------------------------- | ----------------- |
| **Mitra Dashboard** | Stats cards | `mitra/dashboard.blade.php`      | ⚠️ Needs redesign |
| **Mitra Bookings**  | List view   | `mitra/bookings/index.blade.php` | ⚠️ Needs redesign |
| **Mitra Vehicles**  | Grid view   | `mitra/vehicles/index.blade.php` | ⚠️ Needs redesign |
| **Mitra Drivers**   | List view   | `mitra/drivers/index.blade.php`  | ⚠️ Needs redesign |

### **Driver Pages**

| Page                 | Current    | File                         | Status            |
| -------------------- | ---------- | ---------------------------- | ----------------- |
| **Driver Dashboard** | Stats view | `driver/dashboard.blade.php` | ⚠️ Needs redesign |

### **Layout Pages**

| Page              | Current           | File                       | Status          |
| ----------------- | ----------------- | -------------------------- | --------------- |
| **App Layout**    | Header + Footer   | `layouts/app.blade.php`    | ⚠️ **CRITICAL** |
| **Admin Layout**  | Sidebar + Header  | `layouts/admin.blade.php`  | ⚠️ **CRITICAL** |
| **Driver Layout** | Header + Content  | `layouts/driver.blade.php` | ⚠️ **CRITICAL** |
| **Mitra Layout**  | Sidebar + Content | `layouts/mitra.blade.php`  | ⚠️ **CRITICAL** |

---

## 🎨 COLOR REPLACEMENT MAPPING

### **Current Color → New Color**

```
CURRENT (UBER)              NEW (AIRBNB + JATARA)       USAGE
────────────────────────────────────────────────────────────────

#000000 (Black)         →   #0A174E (Oxford Blue)    Header, Text, Logo
#ffffff (White)         →   #EBEBDF (Pale Gray)      Backgrounds, Cards
#efefef (Chip Gray)     →   #EBEBDF (Pale Gray)      Inputs, Neutral BG
#4b4b4b (Text Gray)     →   #0A174E (Oxford Blue)    Body Text
#afafaf (Muted Gray)    →   #EBEBDF (Pale Gray)      Secondary Text

NEW ADDITIONS:
#F5D042 (Maize)                                       CTAs, Hover, Accents
#22C55E (Green)                                       Success states
#EF4444 (Red)                                         Error states
#F59E0B (Orange)                                      Warning states
```

---

## 🔧 COMPONENT CHANGES

### **1. Navigation Bar**

**Current**:

```html
<header class="bg-uber-black text-uber-white">
    <!-- Black background, white text -->
</header>
```

**Target**:

```html
<header class="bg-oxford-blue text-white">
    <!-- Oxford Blue (#0A174E) background -->
    <!-- White text with Maize (#F5D042) hover/active -->
</header>
```

**Changes**:

- ❌ Remove: `bg-uber-black`
- ✅ Add: `bg-[#0A174E]` (Oxford Blue)
- ✅ Hover links: `hover:text-[#F5D042]` (Maize)
- ✅ Active links: `bg-[#F5D042] text-[#0A174E]` (Maize background)

---

### **2. Hero Section**

**Current**:

```html
<section class="...border-gray-50">
    <h1 class="text-uber-black">...</h1>
    <form>
        <select class="bg-uber-chip text-uber-black">
            ...
        </select>
        <button class="btn-primary">Cari</button>
    </form>
</section>
```

**Target**:

```html
<section class="...border-[#EBEBDF]">
    <h1 class="text-[#0A174E]">...</h1>
    <form>
        <select class="bg-[#EBEBDF] text-[#0A174E]">
            ...
        </select>
        <button class="bg-[#F5D042] text-[#0A174E]">Cari</button>
    </form>
</section>
```

**Changes**:

- ❌ Remove: `bg-uber-chip`, `text-uber-black`
- ✅ Add: `bg-[#EBEBDF]` (Pale Gray), `text-[#0A174E]` (Oxford Blue)
- ✅ Button: `bg-[#F5D042] hover:bg-[#E5C232]` (Maize)

---

### **3. Vehicle Listing Cards**

**Current**:

```html
<div class="bg-uber-white border border-gray-100">
    <img src="..." />
    <h2 class="text-uber-black">Vehicle Name</h2>
    <p class="text-uber-text">Description</p>
    <button class="btn-primary">Book</button>
</div>
```

**Target** (AIRBNB Style):

```html
<div class="bg-[#EBEBDF] border border-[#0A174E] border-opacity-15">
    <img src="..." class="rounded-lg" />
    <h2 class="text-[#0A174E]">Vehicle Name</h2>
    <div class="flex justify-between">
        <p class="text-[#0A174E]">Rating: ⭐ 4.9</p>
        <p class="text-[#F5D042] font-bold">Rp 500k/hari</p>
    </div>
    <button class="bg-[#F5D042] text-[#0A174E]">Book Now</button>
</div>
```

**Changes**:

- ❌ Remove: `bg-uber-white`, `text-uber-black`
- ✅ Add: `bg-[#EBEBDF]` (Pale Gray cards)
- ✅ Border: `border-[#0A174E] border-opacity-15` (subtle Oxford Blue)
- ✅ Text: `text-[#0A174E]` (Oxford Blue)
- ✅ Price: `text-[#F5D042]` (Maize highlight)
- ✅ CTA: `bg-[#F5D042] text-[#0A174E]` (Maize button)
- ✅ Hover: `shadow-lg border-l-4 border-l-[#F5D042]` (Maize accent)

---

### **4. Buttons**

**Current**:

```css
.btn-primary {
    @apply bg-uber-black hover:bg-gray-800 text-uber-white;
}
.btn-secondary {
    @apply bg-uber-chip hover:bg-uber-hover text-uber-black;
}
```

**Target**:

```css
.btn-primary {
    @apply bg-[#F5D042] hover:bg-[#E5C232] text-[#0A174E] font-bold;
}
.btn-secondary {
    @apply bg-[#EBEBDF] hover:bg-[#D5D5C9] text-[#0A174E] border border-[#0A174E];
}
```

---

### **5. Forms & Inputs**

**Current**:

```html
<input class="bg-uber-chip text-uber-black border-0" />
```

**Target**:

```html
<input
    class="bg-[#EBEBDF] text-[#0A174E] border border-[#0A174E] focus:border-[#F5D042] focus:ring-[#F5D042]"
/>
```

---

### **6. Footer**

**Current**:

```html
<footer class="bg-uber-black text-uber-white"></footer>
```

**Target**:

```html
<footer class="bg-[#0A174E] text-[#EBEBDF]">
    <a class="text-[#F5D042] hover:underline">Links</a>
</footer>
```

---

## 📋 TAILWIND CONFIG CHANGES

### **Current Configuration** (`layouts/app.blade.php`)

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                uber: {
                    black: "#000000",
                    white: "#ffffff",
                    hover: "#e2e2e2",
                    chip: "#efefef",
                    text: "#4b4b4b",
                    muted: "#afafaf",
                },
            },
        },
    },
};
```

### **Target Configuration**

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                jatara: {
                    "oxford-blue": "#0A174E",
                    "pale-gray": "#EBEBDF",
                    maize: "#F5D042",
                    // Extended for states
                    "oxford-blue-light": "#1A3A7E",
                    "maize-dark": "#D5B222",
                    "maize-darker": "#C5A222",
                },
            },
        },
    },
};
```

---

## 🚀 IMPLEMENTATION PRIORITY

### **Phase 1: CRITICAL** (Global Layout)

```
Priority: 1 - layouts/app.blade.php         (Header, Footer, Nav)
Priority: 2 - layouts/admin.blade.php       (Admin Header, Sidebar)
Priority: 3 - layouts/mitra.blade.php       (Mitra Header, Sidebar)
Priority: 4 - layouts/driver.blade.php      (Driver Header)
```

**Estimated**: 1-2 days
**Impact**: All pages immediately affected

---

### **Phase 2: PUBLIC PAGES** (Customer-Facing)

```
Priority: 5 - home.blade.php                (Hero Section)
Priority: 6 - browse.blade.php              (Vehicle Grid)
Priority: 7 - vehicle-detail.blade.php      (Detail View)
Priority: 8 - checkout.blade.php            (Payment Form) ⭐ HIGH VALUE
Priority: 9 - auth/login.blade.php          (Login)
Priority: 10 - auth/register.blade.php      (Register)
```

**Estimated**: 3-4 days
**Impact**: Main revenue pages

---

### **Phase 3: USER PAGES** (Dashboard)

```
Priority: 11 - user/history.blade.php       (Booking History)
Priority: 12 - user/receipt.blade.php       (Receipt)
Priority: 13 - user/profile.blade.php       (Profile)
```

**Estimated**: 1-2 days
**Impact**: User experience

---

### **Phase 4: ADMIN & MITRA PAGES** (Dashboard)

```
Priority: 14 - admin/dashboard.blade.php    (Admin Stats)
Priority: 15 - admin/bookings/index.blade.php
Priority: 16 - admin/vehicles/index.blade.php
Priority: 17 - admin/drivers/index.blade.php
Priority: 18 - mitra/dashboard.blade.php    (Mitra Stats)
Priority: 19 - mitra/bookings/index.blade.php
Priority: 20 - mitra/vehicles/index.blade.php
Priority: 21 - mitra/drivers/index.blade.php
```

**Estimated**: 3-4 days
**Impact**: Internal operations

---

## 📊 SUMMARY TABLE

| File                       | Type     | Lines  | Changes           | Priority | Estimated Time |
| -------------------------- | -------- | ------ | ----------------- | -------- | -------------- |
| `layouts/app.blade.php`    | Critical | ~300   | 40+ color changes | 1        | 4 hours        |
| `layouts/admin.blade.php`  | Critical | ~150   | 30+ color changes | 2        | 3 hours        |
| `layouts/mitra.blade.php`  | Critical | ~150   | 30+ color changes | 3        | 3 hours        |
| `layouts/driver.blade.php` | Critical | ~100   | 20+ color changes | 4        | 2 hours        |
| `home.blade.php`           | Public   | ~200   | 30+ color changes | 5        | 3 hours        |
| `browse.blade.php`         | Public   | ~300   | 50+ color changes | 6        | 4 hours        |
| `vehicle-detail.blade.php` | Public   | ~250   | 40+ color changes | 7        | 4 hours        |
| `checkout.blade.php`       | Public   | ~400   | 60+ color changes | 8        | 5 hours        |
| `auth/login.blade.php`     | Public   | ~100   | 20+ color changes | 9        | 2 hours        |
| `auth/register.blade.php`  | Public   | ~120   | 25+ color changes | 10       | 3 hours        |
| `user/history.blade.php`   | User     | ~150   | 25+ color changes | 11       | 2 hours        |
| `user/receipt.blade.php`   | User     | ~100   | 15+ color changes | 12       | 2 hours        |
| `user/profile.blade.php`   | User     | ~100   | 15+ color changes | 13       | 2 hours        |
| Admin/Mitra/Driver Pages   | Admin    | ~2000+ | 200+ changes      | 14+      | 8-10 hours     |

**Total Estimated Time**: 40-50 hours (5-7 working days)

---

## 🎯 SPECIFIC FILE CHANGES NEEDED

### **layouts/app.blade.php**

**Header Navigation**:

```diff
- <header id="navbar" class="bg-uber-black text-uber-white">
+ <header id="navbar" class="bg-[#0A174E] text-white">

- <a href="#" class="px-4 py-2 ... hover:bg-white/10">Menu</a>
+ <a href="#" class="px-4 py-2 ... hover:text-[#F5D042]">Menu</a>

- <button class="btn-primary">Login</button>
+ <button class="btn-primary bg-[#F5D042] text-[#0A174E]">Login</button>
```

**Footer**:

```diff
- <footer class="bg-uber-black">
+ <footer class="bg-[#0A174E] text-[#EBEBDF]">

- <a class="text-uber-white">Link</a>
+ <a class="text-[#F5D042]">Link</a>
```

---

### **home.blade.php**

**Hero Heading**:

````diff
- <h1 class="text-4xl ... text-uber-black">
+ <h1 class="text-4xl ... text-[#0A174E]">

**Form Inputs**:
```diff
- <select class="bg-uber-chip text-uber-black">
+ <select class="bg-[#EBEBDF] text-[#0A174E] border border-[#0A174E]">

**Button**:
```diff
- <button class="btn-primary">Cari Sekarang</button>
+ <button class="bg-[#F5D042] text-[#0A174E] hover:bg-[#E5C232]">Cari Sekarang</button>
````

---

### **browse.blade.php**

**Vehicle Cards**:

```diff
- <div class="bg-uber-white border border-gray-100">
+ <div class="bg-[#EBEBDF] border border-[#0A174E] border-opacity-15 hover:border-l-4 hover:border-l-[#F5D042]">

- <h2 class="text-uber-black">
+ <h2 class="text-[#0A174E]">

- <p class="text-xs font-bold text-uber-text">
+ <p class="text-xs font-bold text-[#0A174E]">

- <p class="text-lg font-bold text-uber-black">Rp {{ ... }}</p>
+ <p class="text-lg font-bold text-[#F5D042]">Rp {{ ... }}</p>
```

**Filter Button**:

```diff
- class="region-chip ... bg-uber-black text-uber-white"
+ class="region-chip ... bg-[#0A174E] text-white"

- class="btn-primary"
+ class="bg-[#F5D042] text-[#0A174E] hover:bg-[#E5C232]"
```

---

### **checkout.blade.php**

**Form Headers**:

````diff
- <h1 class="text-3xl font-black text-slate-900">
+ <h1 class="text-3xl font-black text-[#0A174E]">

- <h2 class="text-2xl font-black text-slate-900">
+ <h2 class="text-2xl font-black text-[#0A174E]">

**Section Icons**:
```diff
- <div class="w-12 h-12 bg-blue-600 rounded-2xl">
+ <div class="w-12 h-12 bg-[#F5D042] rounded-2xl">

**Buttons**:
```diff
- <button class="bg-blue-600">Submit</button>
+ <button class="bg-[#F5D042] text-[#0A174E]">Submit</button>

- <button class="bg-slate-900">Cancel</button>
+ <button class="bg-[#0A174E]">Cancel</button>
````

**Input Fields**:

```diff
- <input class="... focus:ring-2 focus:ring-blue-500">
+ <input class="... focus:ring-2 focus:ring-[#F5D042] border-[#0A174E]">
```

---

## ✅ CHECKLIST

### **Pre-Implementation**

- [ ] Backup current code (git branch)
- [ ] Create new Tailwind config
- [ ] Setup CSS variables
- [ ] Create component library documentation

### **Implementation Phase 1 (Layouts)**

- [ ] Update `layouts/app.blade.php`
- [ ] Update `layouts/admin.blade.php`
- [ ] Update `layouts/mitra.blade.php`
- [ ] Update `layouts/driver.blade.php`
- [ ] Test all layouts in browser

### **Implementation Phase 2 (Public Pages)**

- [ ] Update `home.blade.php`
- [ ] Update `browse.blade.php`
- [ ] Update `vehicle-detail.blade.php`
- [ ] Update `checkout.blade.php`
- [ ] Update auth pages

### **Implementation Phase 3 (User Pages)**

- [ ] Update user booking pages
- [ ] Update user profile pages
- [ ] Update receipt pages

### **Implementation Phase 4 (Admin/Mitra)**

- [ ] Update admin dashboard
- [ ] Update admin CRUD pages
- [ ] Update mitra pages
- [ ] Update driver pages

### **Testing & QA**

- [ ] Responsive testing (mobile, tablet, desktop)
- [ ] Cross-browser testing
- [ ] Contrast ratio verification (WCAG)
- [ ] Performance testing
- [ ] User acceptance testing

---

## 📝 NOTES

1. **Gradual Migration**: Update layouts first, then pages trickle down
2. **Component Reuse**: Use Tailwind `@apply` for consistent styling
3. **Testing**: Test each phase before moving to next
4. **Git Commits**: Commit after each logical group of changes
5. **Fallbacks**: Keep old colors in CSS variables temporarily for safety

---

**Total Estimated Project Duration**: 1 week (5-7 working days)  
**Resource Required**: 1-2 Frontend Developer  
**Risk Level**: Low (color-only changes, no logic changes)  
**Expected Impact**: High (improved visual identity, brand recognition)

---

**Last Updated**: April 16, 2026  
**Next Step**: Start Phase 1 - Global Layout Changes
