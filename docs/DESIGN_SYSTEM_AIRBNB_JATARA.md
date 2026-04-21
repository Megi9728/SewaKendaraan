# 🎨 DESIGN SYSTEM: AIRBNB + JATARA BRAND COLORS

**Project**: SewaKendaraan (JATARA - Jasa Transportasi Rental & Armada)  
**Design Framework**: AIRBNB UX Principles  
**Color System**: JATARA Brand Palette  
**Date**: April 16, 2026  
**Status**: Design System Definition

---

## ✨ WHY AIRBNB?

### **Perfect Match for JATARA**

```
✅ Marketplace Platform Model        → Vehicle rental is a marketplace
✅ Trust & Safety Design             → Critical for customer confidence
✅ Card-Based Layouts                → Perfect for vehicle listings
✅ Strong Visual Hierarchy           → Clear, organized information
✅ Community-Driven UX               → Renters ↔ Hosts interaction
✅ Mobile-First Approach             → Essential for bookings
✅ Excellent Booking Flow            → Same user journey pattern
```

**AIRBNB Design DNA Applied to JATARA:**

- Warm, welcoming aesthetic
- Trust through transparent design
- Beautiful card systems for browsing
- Clear, intuitive CTAs
- Safety/verification messaging
- Rating & review system

---

## 🎨 COLOR MAPPING: AIRBNB → JATARA

### **AIRBNB Original Colors vs JATARA Adaptation**

```
AIRBNB FRAMEWORK          PURPOSE              JATARA COLOR          HEX CODE
────────────────────────────────────────────────────────────────────────────

#FF5A5F (Coral)       →  Primary Action   →  Maize            #F5D042
                         Energy, CTAs         (Warm Yellow)

#FFFFFF (White)       →  Clean Space      →  Pale Gray        #EBEBDF
                         Backgrounds          (Soft Background)

#222222 (Dark)        →  Text & Trust     →  Oxford Blue      #0A174E
                         Headers, Text        (Deep Blue)

#FF5A5F (Accent)      →  Highlights       →  Maize            #F5D042
                         Emphasis             (Hover/Focus)
```

### **Why These Mappings?**

| JATARA Color            | AIRBNB Role            | Why It Works                                 |
| ----------------------- | ---------------------- | -------------------------------------------- |
| **Oxford Blue #0A174E** | #222222 (Dark text)    | Professional, trustworthy, high contrast     |
| **Pale Gray #EBEBDF**   | #FFFFFF (Clean white)  | Sophisticated, not harsh on eyes             |
| **Maize #F5D042**       | #FF5A5F (Coral energy) | Warm, energetic, perfect for booking buttons |

---

## 📐 COMPONENT STYLING

### **1. Navigation & Header**

```css
header {
    background-color: #0a174e; /* Oxford Blue */
    color: #ffffff; /* White text */
}

header a {
    color: #ebebdf; /* Pale Gray */
}

header a:hover {
    color: #f5d042; /* Maize accent */
    border-bottom: 2px solid #f5d042;
}

header a.active {
    background-color: #f5d042; /* Maize */
    color: #0a174e; /* Oxford Blue text */
}
```

### **2. Vehicle Listing Cards** ⭐ (AIRBNB-Style)

```css
.vehicle-card {
    background-color: #ebebdf; /* Pale Gray */
    border: 1px solid rgba(10, 23, 78, 0.15); /* Subtle Oxford Blue border */
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.vehicle-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    transform: translateY(-4px);
    border-left: 4px solid #f5d042; /* Maize accent */
}

.vehicle-card-image {
    width: 100%;
    height: 200px;
    border-radius: 8px 8px 0 0;
    object-fit: cover;
}

.vehicle-card-title {
    color: #0a174e; /* Oxford Blue */
    font-size: 18px;
    font-weight: 600;
    margin-top: 12px;
}

.vehicle-card-price {
    color: #f5d042; /* Maize */
    font-size: 20px;
    font-weight: 700;
}

.vehicle-card-rating {
    color: #f5d042; /* Maize stars */
}
```

### **3. CTA Buttons**

#### **Primary Button (Book Now)**

```css
.btn-primary {
    background-color: #f5d042; /* Maize */
    color: #0a174e; /* Oxford Blue text */
    border: none;
    border-radius: 6px;
    font-weight: 600;
    padding: 12px 24px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background-color: #e5c232; /* Maize -10% */
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(245, 208, 66, 0.3);
}

.btn-primary:active {
    background-color: #d5b222; /* Maize -20% */
    transform: scale(0.98);
}
```

#### **Secondary Button (Browse)**

```css
.btn-secondary {
    background-color: transparent;
    color: #0a174e; /* Oxford Blue */
    border: 1px solid #0a174e; /* Oxford Blue border */
    border-radius: 6px;
    font-weight: 600;
    padding: 12px 24px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    background-color: #0a174e; /* Oxford Blue */
    color: #ffffff; /* White text */
}
```

### **4. Search/Filter Section**

```css
.search-container {
    background-color: #ebebdf; /* Pale Gray */
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}

.filter-input {
    background-color: #ffffff;
    border: 1px solid #0a174e; /* Oxford Blue */
    color: #0a174e;
    border-radius: 6px;
    padding: 10px 12px;
}

.filter-input:focus {
    border-color: #f5d042; /* Maize */
    outline: none;
    box-shadow: 0 0 0 3px rgba(245, 208, 66, 0.1);
}
```

### **5. Footer**

```css
footer {
    background-color: #0a174e; /* Oxford Blue */
    color: #ebebdf; /* Pale Gray */
}

footer a {
    color: #f5d042; /* Maize */
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

footer hr {
    border-color: rgba(235, 235, 223, 0.2); /* Pale Gray transparent */
}
```

---

## 📱 RESPONSIVE DESIGN (Mobile-First AIRBNB Style)

### **Mobile (320px - 768px)**

```css
/* Full-width cards */
.vehicle-card {
    width: 100%;
    margin-bottom: 16px;
}

/* Stacked layout */
.vehicle-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
}

/* Large touch targets */
button,
input {
    min-height: 48px;
}

/* Prominent CTAs */
.btn-primary {
    width: 100%;
    font-size: 16px;
}
```

### **Tablet (768px - 1024px)**

```css
.vehicle-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}
```

### **Desktop (1024px+)**

```css
.vehicle-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* More spacious design */
.container {
    max-width: 1200px;
    margin: 0 auto;
}
```

---

## 🎯 LAYOUT PATTERNS (AIRBNB-Inspired)

### **Hero Section**

```
┌─────────────────────────────────────┐
│  Header (Oxford Blue)               │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│  Search Box (Pale Gray background)  │
│  [Location ▼] [Dates] [Search 🔍]  │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│  Featured Vehicles (Large Banner)   │
│  Main CTA (Maize Button)            │
└─────────────────────────────────────┘
```

### **Vehicle Listing Grid**

```
┌──────────────┐  ┌──────────────┐  ┌──────────────┐
│              │  │              │  │              │
│   Vehicle 1  │  │   Vehicle 2  │  │   Vehicle 3  │
│   (Card)     │  │   (Card)     │  │   (Card)     │
│              │  │              │  │              │
└──────────────┘  └──────────────┘  └──────────────┘
```

Each card contains:

- Image (Pale Gray background)
- Title (Oxford Blue text)
- Rating (Maize stars)
- Price (Maize highlight)
- Description (Oxford Blue text)
- CTA Button (Maize)

### **Footer**

```
┌─────────────────────────────────────┐
│  Footer (Oxford Blue background)    │
│                                     │
│  Links (Maize color)                │
│  Copyright (Pale Gray)              │
└─────────────────────────────────────┘
```

---

## 🎨 COLOR CONSTANTS (Tailwind + CSS Variables)

### **Tailwind Configuration**

```javascript
// tailwind.config.js
export default {
    theme: {
        extend: {
            colors: {
                "oxford-blue": "#0A174E",
                "pale-gray": "#EBEBDF",
                maize: "#F5D042",
                // Extended for states
                "oxford-blue-light": "#1A3A7E",
                "maize-dark": "#D5B222",
            },
        },
    },
};
```

### **CSS Variables (Fallback)**

```css
:root {
    /* Primary Colors */
    --color-oxford-blue: #0a174e;
    --color-pale-gray: #ebebdf;
    --color-maize: #f5d042;

    /* Semantic Colors */
    --color-primary: var(--color-oxford-blue);
    --color-secondary: var(--color-pale-gray);
    --color-accent: var(--color-maize);

    /* Component Colors */
    --bg-primary: var(--color-oxford-blue);
    --bg-secondary: var(--color-pale-gray);
    --text-primary: var(--color-oxford-blue);
    --text-secondary: #666666;
    --border-color: rgba(10, 23, 78, 0.15);

    /* State Colors */
    --color-success: #22c55e;
    --color-error: #ef4444;
    --color-warning: #f59e0b;
    --color-info: #3b82f6;
}
```

---

## 🔄 IMPLEMENTATION PHASES

### **Phase 1: Foundation** ✅

- ✅ Color palette defined
- ✅ AIRBNB design system selected
- 📋 Tailwind configuration
- 📋 CSS variables setup

### **Phase 2: Core Components** (Next)

- [ ] Navigation header
- [ ] Vehicle card component
- [ ] Button components (primary, secondary)
- [ ] Search filter section
- [ ] Footer

### **Phase 3: Pages Implementation**

- [ ] Home page (hero + featured)
- [ ] Browse/Jelajah page (card grid)
- [ ] Vehicle detail page
- [ ] Checkout page

### **Phase 4: Admin & Mitra Dashboards**

- [ ] Mitra dashboard
- [ ] Admin dashboard
- [ ] Booking management

### **Phase 5: Polish & Launch**

- [ ] Responsive testing
- [ ] Accessibility audit (WCAG)
- [ ] Performance optimization
- [ ] Cross-browser testing

---

## 📚 REFERENCE FILES

Location: `/laragonwwwui-ux-skill-temp/`

```
public/awesome-design-md-main/design-md/airbnb/
├── DESIGN.md              ← AIRBNB Design Principles
├── preview.html           ← AIRBNB UI Components
└── preview-dark.html      ← Dark Mode Variation
```

**How to Use**:

1. Open `preview.html` in browser
2. Study AIRBNB component patterns
3. Adapt layout with JATARA colors
4. Reference typography and spacing

---

## 📊 QUICK REFERENCE TABLE

| Element          | Color       | Hex     | RGB             |
| ---------------- | ----------- | ------- | --------------- |
| Header/Footer BG | Oxford Blue | #0A174E | (10, 23, 78)    |
| Card/Section BG  | Pale Gray   | #EBEBDF | (235, 235, 223) |
| Button/CTA       | Maize       | #F5D042 | (245, 208, 66)  |
| Text/Headlines   | Oxford Blue | #0A174E | (10, 23, 78)    |
| Hover/Focus      | Maize       | #F5D042 | (245, 208, 66)  |
| Links            | Maize       | #F5D042 | (245, 208, 66)  |

---

## ✅ DESIGN PRINCIPLES (AIRBNB + JATARA)

1. **Trust**: Oxford Blue communicates professionalism
2. **Warmth**: Maize accents create welcoming energy
3. **Clarity**: Pale Gray provides clean, organized spaces
4. **Action**: Bold CTAs in Maize drive bookings
5. **Consistency**: Same colors across all pages
6. **Accessibility**: High contrast ratios maintained
7. **Mobile-First**: Responsive design from ground up
8. **Community**: Ratings & reviews featured prominently

---

**Status**: Ready for Implementation  
**Next Step**: Start Phase 2 - Build Core Components  
**Last Updated**: April 16, 2026
