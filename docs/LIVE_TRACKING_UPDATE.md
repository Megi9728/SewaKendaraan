# 📌 LIVE TRACKING FEATURE UPDATE (2026-04-16)

**Status**: Just pulled from remote  
**Feature**: Real-time GPS tracking for rental vehicles  
**Impact**: 2 new pages to restyling

---

## 🆕 NEW PAGES ADDED

### **1. Mitra Monitoring Dashboard**

**File**: `resources/views/mitra/monitoring.blade.php`  
**Purpose**: Live real-time vehicle tracking for mitra (fleet owners)

**Current Styling**: Mixed (blue + slate)  
**Target Styling**: AIRBNB + JATARA Colors

**Components to Restyle**:

```
✓ Vehicle list sidebar      → Pale Gray background (#EBEBDF)
✓ Live status badge         → Green indicator (keep green)
✓ Vehicle icon              → Oxford Blue (#0A174E) by default
✓ Active vehicle highlight  → Maize (#F5D042) on left border
✓ Offline indicator         → Gray status
✓ Map area                  → Pale Gray background
```

---

### **2. GPS Device Tracker**

**File**: `resources/views/tracker/device.blade.php`  
**Purpose**: Standalone GPS tracking page for rental customers

**Current Styling**: Dark slate background (#1e293b)  
**Target Styling**: AIRBNB + JATARA Colors

**Components to Restyle**:

```
✓ Background               → Keep dark or use Oxford Blue (#0A174E)
✓ Card container           → Pale Gray (#EBEBDF) with Oxford Blue text
✓ Status icon area         → Oxford Blue background
✓ Location displays        → Oxford Blue text (#0A174E)
✓ Start Tracking button    → Maize (#F5D042) CTA
✓ Stop button              → Oxford Blue (#0A174E)
✓ Status text              → Pale Gray (#EBEBDF)
✓ Live indicator dot       → Green (success color)
```

---

## 🗄️ DATABASE UPDATES

**VehicleUnit Model** - New fields added:

```php
'latitude'         → decimal(10,8)    // GPS latitude
'longitude'        → decimal(11,8)    // GPS longitude
'last_tracked_at'  → timestamp        // Last GPS update
'tracking_token'   → string(32)       // Unique token per unit
```

---

## 🔄 PRIORITY UPDATE

**New Implementation Order**:

```
Phase 1: Global Layouts (Unchanged)
Phase 2: Public Pages (Unchanged)
Phase 3: User Pages (Unchanged)
Phase 4: LIVE TRACKING ⭐ NEW
├─ Priority 14: mitra/monitoring.blade.php
└─ Priority 15: tracker/device.blade.php

Phase 5: Admin & Mitra Pages
```

**Estimated Additional Time**: 3-4 hours for both tracking pages

**Total Project**: 45-55 hours (was 40-50 hours)

---

## 💡 STYLING RECOMMENDATIONS

### **Mitra Monitoring - Visual Hierarchy**

```
1. Left Sidebar (Vehicle List)
   - Background: Pale Gray (#EBEBDF)
   - Borders: Subtle Oxford Blue with 15% opacity
   - Active vehicle: Maize left border accent (#F5D042)
   - Hover: Light shadow lift

2. Main Map Area
   - Background: Pale Gray (#EBEBDF)
   - Map provider styling: Keep current but add Maize pins
   - Zoom controls: Oxford Blue background

3. Live Status Indicators
   - LIVE (green): Keep #22C55E (green)
   - OFF (offline): Gray #9ca3af
   - No data: Slate #cbd5e1
```

### **GPS Tracker Device - Aesthetic**

```
Option A: Keep Dark Theme
- Background: #1a1a2e or similar dark
- Card: Pale Gray (#EBEBDF) with Oxford Blue text
- Creates nice contrast for outdoor visibility

Option B: Light Theme (Recommended for AIRBNB consistency)
- Background: Pale Gray (#EBEBDF)
- Card: White with Oxford Blue text
- Button: Maize CTA (#F5D042)
```

**Recommendation**: Use Option A (dark) for GPS tracker device = better outdoors visibility + matches tracker aesthetic

---

## ✅ IMPLEMENTATION CHECKLIST

### **Before Starting Restyling**

- [ ] Verify live tracking works (no breaking changes)
- [ ] Test GPS functionality
- [ ] Check tracking token generation

### **Mitra Monitoring Restyling**

- [ ] Sidebar vehicle list colors
- [ ] Status indicators (live/offline)
- [ ] Active vehicle highlighting (Maize border)
- [ ] Hover effects
- [ ] Map area styling
- [ ] Responsive mobile layout
- [ ] Test on multiple device sizes

### **GPS Tracker Restyling**

- [ ] Background color (keep dark or light)
- [ ] Card container colors
- [ ] Button styling (Maize CTA)
- [ ] Location data display
- [ ] Status icons and text
- [ ] Live indicator animation
- [ ] Outdoor visibility check

---

**Status**: Ready to incorporate into Phase 4  
**Next Step**: Start Phase 1 Global Layout Restyling → Phase 4 will follow after public pages
