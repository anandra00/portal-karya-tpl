---
name: phpspreadsheet
description: Guidelines for generating premium styled Excel exports in this workspace.
---

When building or updating Excel export features:
1. Use `PhpOffice\PhpSpreadsheet` library.
2. Styling requirements:
   - Use `mergeCells` for report title headers.
   - Use dark headers (e.g. indigo `#4F46E5` or dark gray `#1F2937`) with white text.
   - Set custom row heights (e.g., header: 30-40px, data: 22px).
   - Apply zebra striping on data rows (alternate background between `#F3F4F6` and `#FFFFFF`).
   - Define custom column widths to prevent text clipping.
3. Stream the file directly as an attachment download: `response()->streamDownload(...)`.
