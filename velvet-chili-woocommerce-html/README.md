# Velvet Chili – WooCommerce Restaurant Website Theme

A fully responsive, modern restaurant website theme built for **WordPress & WooCommerce**.  
Designed around the warm, spicy identity of the fictional **Velvet Chili** restaurant, the theme includes a dynamic menu, reservation form, event slider, and a filterable product catalogue – all crafted with clean, BEM‑structured CSS and vanilla JavaScript.

![Velvet Chili Hero](https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070&auto=format&fit=crop)

---

## ✨ Features

- **Full‑width, responsive design** – looks perfect on mobile, tablet, and desktop.
- **Sticky header** with smooth mobile hamburger menu.
- **Hero image slider** with auto‑play, arrows, and dot navigation.
- **About page** with chef story, philosophy, and an event image carousel.
- **Dynamic product grid** – WooCommerce‑ready product cards with “Add to Cart” buttons.
- **Category filter bar** – allows filtering menu items by category (Starters, Mains, etc.).
- **Single product detail page** – large image, description, dietary tags, and chef’s note.
- **Testimonials carousel** – dark overlay box with auto‑rotating customer quotes.
- **Reservation form** with opening hours panel (static front‑end).
- **Contact page** with form, contact info, and placeholder map.
- **Legal pages** – Privacy Policy, Terms of Service, and Accessibility statement.
- **Full menu page** with grid layout and category filtering.
- **Optimised for WooCommerce** – all product cards use WooCommerce classes and can be dynamically populated.
- **Minimal dependencies** – only Font Awesome and Google Fonts are external; no jQuery, no heavy libraries.
- **Clean, maintainable code** – CSS follows BEM methodology, JS is modular with a shared slider factory.

---

## 🛠 Tech Stack

| Technology       | Usage                                            |
| ---------------- | ------------------------------------------------ |
| HTML5            | Semantic markup                                  |
| CSS3             | Custom properties, Flexbox, CSS Grid, BEM naming |
| JavaScript (ES6) | Mobile nav, sliders, filter                      |
| Font Awesome 6   | Icons                                            |
| Google Fonts     | Cormorant Garamond & Montserrat                  |
| Unsplash         | Placeholder images                               |

---

## 🚀 Getting Started

1. **Clone or download** the repository.
2. Open `index.html` in your browser to see the full site.
3. For development, edit:
   - `base.css` – change design tokens (colours, fonts) in `:root`.
   - `theme.css` – adjust component styles.
   - `main.js` – modify slider speeds, filter behaviour, or add new interactive elements.

No build tools or server is required – it works out of the box.

---

## 🎨 Customization

### Colours & Typography

All design tokens are stored as CSS custom properties in `base.css`:

```css
:root {
  --color-chili-red: #b23a2d;
  --font-heading: "Cormorant Garamond", Georgia, serif;
  --font-body: "Montserrat", "Helvetica Neue", sans-serif;
  /* … */
}
```
