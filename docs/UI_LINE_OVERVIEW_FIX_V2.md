# UI Line + Dashboard Overview Fix v2

- Fixed the broken/misaligned horizontal divider in Books and Borrowers tables.
- Root cause: `display:flex` was applied directly to a `<td class="actions">`, which made the action cell stop behaving like a table cell.
- Action buttons now use an inner `.action-buttons` flex wrapper while the `<td>` remains a table-cell.
- Reworked the Dashboard Overview into a clearer catalog-status panel, recent rental activity, quick actions, and active-rental section.
- Existing CRUD and rental/return logic is unchanged.
