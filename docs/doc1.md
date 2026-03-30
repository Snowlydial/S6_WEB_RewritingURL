# Project Log: Article CMS Module (CUD)

Back-Office article management — implementation log and technical reference.

---

## 1. Functional Overview

The system allows an administrator to manage the site's content through a secure, persistent interface.

- **Create / Update:** A unified form for adding new articles or editing existing ones.
- **Persistent Storage:** Data is stored in a MySQL database, which survives Docker container restarts.
- **Delete:** Removal of articles via ID-based routing.
- **Media Management:** Support for local image uploads directly within the content.

---

## 2. Core Features & Implementation

### Advanced Rich Text Editing

TinyMCE 8 was integrated to provide a Word-like editing experience.

- **Customization:** Supports blocks (h1–h6), lists, tables, and media.
- **Image Handling:** Custom integration with a Spring Boot controller to store images locally in an `/uploads` folder rather than bloating the database with Base64 strings.
- **Path Persistence:** Configured `convert_urls: false` to ensure image paths remain absolute (`/uploads/...`), preventing broken links when editing articles from different URL depths.

### Local Image Processing

To prevent server storage issues and slow load times:

- **Thumbnailator Integration:** Every uploaded image is automatically resized to a maximum of 800x800px.
- **Format Optimization:** Images are converted to `.jpg` with 80% quality compression to ensure the site passes Lighthouse performance audits.
- **Docker Volumes:** The `uploads/` directory is mapped to the host machine, ensuring images are never lost during deployment.

### SEO & Technical Requirements (Lighthouse Ready)

Based on the instructor's checklist:

- **URL Normalization (Slugs):** Automatic generation of URL-friendly strings (e.g., `My Article` → `my-article`) using Regex and Normalizer.
- **Auto-Summary:** Background logic that strips HTML tags from the content to create a clean text summary (Title + first 150 chars) for `<meta>` tags and search results.
- **Alt Text Support:** The image upload flow allows for manual alternative description entry to satisfy accessibility requirements.
- **Heading Structure:** TinyMCE is configured to encourage proper `h1` through `h6` hierarchy.

---

## 3. Technical Architecture

- **Backend:** Spring Boot 3.2.4 (Java 17)
- **Database:** MySQL 8.0 (Persistent via Docker)
- **Frontend:** Thymeleaf + TinyMCE
- **File Serving:** `MvcConfig` configured to expose the external `uploads/` folder as a web-accessible resource.
