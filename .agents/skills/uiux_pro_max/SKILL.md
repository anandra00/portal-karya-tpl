---
name: uiux_pro_max
description: Guidelines for building premium, modern web interfaces with rich aesthetics, smooth animations, glassmorphism, and dark mode support.
---

When designing, updating, or styling user interfaces in this workspace:

1. **Visual Excellence & Branding**:
   - Avoid standard generic colors (plain red, blue, green). Use curated palettes like Indigo, Violet, Emerald, Slate, and HSL-tailored colors.
   - Use premium typography. Always check for Google Fonts (e.g., Outfit, Inter, Plus Jakarta Sans) rather than system defaults.
   - Use soft gradients (e.g., `bg-gradient-to-br from-indigo-650 via-indigo-800 to-purple-900`).

2. **Glassmorphism & Shadows**:
   - For premium components, use backdrop blur and subtle transparent borders:
     `bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-white/20 dark:border-gray-800/30`.
   - Apply elevation with soft, layered shadow effects (`shadow-xl`, custom drop-shadows).

3. **Micro-animations & Interactions**:
   - Every interactive element (buttons, cards, links) must have hover transitions:
     `transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg`.
   - Use Alpine.js or CSS keyframes for smooth fade-in, slide-up, and layout scaling animations.

4. **Responsive Layouts**:
   - Build responsive grids using CSS grid / flexbox (`grid-cols-1 md:grid-cols-2 lg:grid-cols-3`).
   - Add appropriate padding/spacing (`py-20`, `px-6 sm:px-10`).

5. **No Placeholders**:
   - If an image is needed, generate a real demonstration asset or use dynamic unspash links, never use blank boxes or "TODO" text.
