# Business Settings - Visual Guide

## Page Layout Overview

```
┌─────────────────────────────────────────────────────────────────┐
│  Dashboard > Settings > Business Settings                       │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│  ✓ Success Alert (if form was saved)                           │
│  Business settings updated successfully!                  [×]    │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                                                                 │
│  Business Identity                                              │
│  ─────────────────────────────────────────────────────────────  │
│                                                                 │
│  Business Name *              │  Founder Name                   │
│  [Enter business name    ]    │  [Enter founder name      ]     │
│                                                                 │
│  Business Category            │  Date Founded                   │
│  [Select Category      ▼]     │  [📅 MM/DD/YYYY          ]     │
│                                                                 │
│  Business Logo (Recommended: 200px X 200px)                     │
│  [Choose File] No file chosen                                   │
│                                                                 │
│  Current Logo:                                                  │
│  ┌──────────┐                                                   │
│  │          │                                                   │
│  │  [LOGO]  │ ← Current logo preview                            │
│  │          │                                                   │
│  └──────────┘                                                   │
│                                                                 │
│  ┌──────────┐                                                   │
│  │          │                                                   │
│  │  [NEW]   │ ← New upload preview                              │
│  │          │                                                   │
│  └──────────┘                                                   │
│                                                                 │
│  ─────────────────────────────────────────────────────────────  │
│                                                                 │
│  Contact Information                                            │
│  ─────────────────────────────────────────────────────────────  │
│                                                                 │
│  Phone Number                 │  Business Email *               │
│  [+1 (234) 567-8900     ]     │  [business@example.com    ]     │
│                                                                 │
│  Website URL                                                    │
│  [https://www.example.com                                 ]     │
│                                                                 │
│  Business Address                                               │
│  [                                                        ]     │
│  [                                                        ]     │
│  [                                                        ]     │
│                                                                 │
│  ─────────────────────────────────────────────────────────────  │
│                                                                 │
│  Regional Settings                                              │
│  ─────────────────────────────────────────────────────────────  │
│                                                                 │
│  Currency *                   │  Timezone *                     │
│  [USD - US Dollar ($)    ▼]   │  [Eastern Time (ET)      ▼]    │
│                                                                 │
│  ─────────────────────────────────────────────────────────────  │
│                                                                 │
│  Business Status                                                │
│  ─────────────────────────────────────────────────────────────  │
│                                                                 │
│  ◉ Business is Active                                           │
│  When disabled, no transactions can be processed for this       │
│  business.                                                      │
│                                                                 │
│                                                                 │
│            ┌─────────┐  ┌──────────────┐                        │
│            │  Reset  │  │ Save Changes │                        │
│            └─────────┘  └──────────────┘                        │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

## Color Scheme

### Form Elements
- **Input Fields**: White background, light gray border, rounded corners (radius-8)
- **Labels**: Dark gray text, semi-bold weight
- **Required Field Markers**: Red asterisk (*)
- **Validation Errors**: Red text below field, red border on input

### Buttons
- **Reset Button**: 
  - Border: Danger red
  - Text: Danger red
  - Hover: Light red background
  - Icon: Refresh icon

- **Save Button**:
  - Background: Primary blue
  - Text: White
  - Border: Primary blue
  - Icon: Save icon

### Alerts
- **Success Alert**:
  - Background: Light green
  - Icon: Check circle (green)
  - Text: Dark green
  - Dismissible with X button

- **Error Alert**:
  - Background: Light red
  - Icon: Alert circle (red)
  - Text: Dark red
  - Dismissible with X button

## Section Breakdown

### 1. Business Identity Section
```
┌─────────────────────────────────────────────────┐
│ Business Identity                               │
│                                                 │
│ 📝 Business Name * ────────────────────────────  │
│ 👤 Founder Name ───────────────────────────────  │
│ 🏢 Business Category ──────────────────────────  │
│ 📅 Date Founded ───────────────────────────────  │
│ 🖼️  Business Logo Upload & Preview              │
└─────────────────────────────────────────────────┘
```

### 2. Contact Information Section
```
┌─────────────────────────────────────────────────┐
│ Contact Information                             │
│                                                 │
│ 📞 Phone Number ───────────────────────────────  │
│ 📧 Business Email * ───────────────────────────  │
│ 🌐 Website URL ────────────────────────────────  │
│ 📍 Business Address ───────────────────────────  │
└─────────────────────────────────────────────────┘
```

### 3. Regional Settings Section
```
┌─────────────────────────────────────────────────┐
│ Regional Settings                               │
│                                                 │
│ 💰 Currency * ─────────────────────────────────  │
│ 🕐 Timezone * ─────────────────────────────────  │
└─────────────────────────────────────────────────┘
```

### 4. Business Status Section
```
┌─────────────────────────────────────────────────┐
│ Business Status                                 │
│                                                 │
│ ◉ Business is Active                            │
│ ℹ️ Warning: When disabled, no transactions     │
│   can be processed for this business.           │
└─────────────────────────────────────────────────┘
```

## Form States

### Empty Form (New Business)
- All fields are empty except:
  - Currency: Defaults to "USD - US Dollar ($)"
  - Timezone: Defaults to "America/New_York" (Eastern Time)
  - Is Active: Checked by default

### Populated Form (Existing Business)
- All fields show existing values
- Current logo displays if uploaded
- Date founded shows in MM/DD/YYYY format

### Validation Error State
```
┌─────────────────────────────────────────────────┐
│ ⚠️ Error Alert                                  │
│ • The business name field is required.          │
│ • The email field is required.                  │
│ • The logo must be an image.                    │
└─────────────────────────────────────────────────┘

Business Name *
[                        ] ← Red border
⚠️ The business name field is required. ← Red text
```

### Success State
```
┌─────────────────────────────────────────────────┐
│ ✓ Success Alert                           [×]   │
│ Business settings updated successfully!         │
└─────────────────────────────────────────────────┘
```

## Interactive Elements

### Logo Upload Process
1. **Initial State**: "Choose File" button + text "No file chosen"
2. **File Selected**: Button shows filename
3. **Preview Loads**: Image appears in preview box below
4. **Current Logo**: Displayed in separate box if exists
5. **After Save**: New logo becomes current logo

### Form Actions
- **Reset Button**: 
  - Clears all form fields
  - Resets to default values
  - No confirmation dialog (browser default)

- **Save Button**:
  - Validates all fields
  - Shows loading state (optional)
  - Submits via PUT request
  - Redirects with success/error message

## Responsive Behavior

### Desktop (>768px)
```
┌─────────────┬─────────────┐
│  Field A    │  Field B    │
├─────────────┼─────────────┤
│  Field C    │  Field D    │
└─────────────┴─────────────┘
```

### Tablet/Mobile (<768px)
```
┌───────────────────────────┐
│  Field A                  │
├───────────────────────────┤
│  Field B                  │
├───────────────────────────┤
│  Field C                  │
├───────────────────────────┤
│  Field D                  │
└───────────────────────────┘
```

## Sidebar Integration

### Settings Section in Sidebar
```
Settings
├── Business Settings  ← Active page highlighted
│   └── (You are here)
```

### Active State Indicator
- Background: Light blue
- Border-left: 3px solid primary blue
- Text: Primary blue (bold)
- Icon: Primary blue

## Icons Used (Iconify)

| Element | Icon |
|---------|------|
| Settings Menu | `tabler:settings` |
| Success Alert | `mdi:check-circle` |
| Error Alert | `mdi:alert-circle` |
| Reset Button | `mdi:refresh` |
| Save Button | `mdi:content-save` |

## Typography

| Element | Style |
|---------|-------|
| Page Title | Not shown (in breadcrumb) |
| Section Headings | `.text-xl` (20px), medium weight |
| Field Labels | `.text-sm` (14px), semi-bold |
| Input Text | 16px, regular weight |
| Help Text | `.text-sm` (14px), light gray |
| Placeholders | Light gray, italic |

## Spacing & Layout

- **Card Padding**: 40px all sides (p-40)
- **Section Spacing**: 40px bottom margin (mb-40)
- **Field Spacing**: 20px bottom margin (mb-20)
- **Row Gaps**: 12px vertical (gy-3)
- **Button Gap**: 12px between buttons (gap-3)
- **Border Radius**: 12px for card, 8px for inputs

## Accessibility Features

✅ **Form Labels**: All inputs have associated labels
✅ **Required Indicators**: Visual (*) and semantic (required attribute)
✅ **Error Messages**: Associated with fields, screen reader friendly
✅ **Focus States**: Visible focus indicators on all inputs
✅ **Button Text**: Clear, descriptive button labels
✅ **Alt Text**: Logo images have alt attributes
✅ **Color Contrast**: WCAG AA compliant text colors

## Browser Compatibility

✅ Chrome (latest)
✅ Firefox (latest)
✅ Safari (latest)
✅ Edge (latest)
✅ Opera (latest)

## Performance

- **Page Load**: Fast (minimal assets)
- **Form Submission**: AJAX-ready (currently uses traditional form submit)
- **Image Upload**: Client-side validation before upload
- **File Size**: Validated server-side (max 2MB)

---

**Note**: This visual guide represents the Business Settings page design. The actual implementation matches the existing ArkSheet design system for consistency.

