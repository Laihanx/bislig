# Explore Bislig City – Static Site

This repository now contains a fully static version of the Explore Bislig City experience. The project has been refactored to use plain HTML and CSS only—no build tools, JavaScript frameworks, or package managers are required.

## Project Structure

- `index.html` – Landing page with highlights, navigation, and calls to action
- `destinations.html`, `restaurants.html`, `accommodations.html`, `transportation.html`, `attractions.html`, `festivals.html`, `emergency.html`, `admin.html`
- `styles.css` – Shared stylesheet with the black, white, blue, and green palette
- `assets/` – Image assets referenced directly by the static pages

## Getting Started

Open `index.html` in any modern browser to browse the site locally. Because every page is self-contained HTML, you can:

- Double-click `index.html` (suitable for quick previews), or
- Serve the folder with any static server, e.g.:

```sh
# Using Python
python -m http.server 5173

# Using npm's serve (if installed globally)
serve .
```

Then visit `http://localhost:5173/index.html`.

## Editing the Site

1. Update markup in the relevant `.html` file.
2. Adjust shared styles in `styles.css` if needed.
3. Place additional images inside `assets/` and reference them directly (e.g. `assets/new-photo.jpg`).

No build or compilation step is required—refresh the browser to see your changes.

## Deployment

Deploy the contents of the repository with any static hosting provider such as GitHub Pages, Netlify, or Vercel. Point the host to the repository root so that `index.html` is served as the entry point.
