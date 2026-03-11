<img src="solidwork-logo.svg" alt="Solidwork" width="150">

# Contao Backend Labels Bundle

Enhances the Contao 5 backend by displaying CSS ID and CSS class directly in the labels of content elements and articles — so you can identify styled elements at a glance without opening them.

## Features

- **Content elements:** Shows `cssID` and `cssClass` in the element label. For `element_group`, also shows the number of child elements.
- **Articles:** Shows `cssID` and `cssClass` in the article label.
- **Per user group:** Enhanced labels are opt-in — only members of groups with the setting enabled will see them. Admins always see them.

## Requirements

- PHP ^8.1
- Contao ^5.3

## Installation

Install via Composer:

```bash
composer require solidwork/contao-backend-labels-bundle
```

Or install via the **Contao Manager**.

After installation, run the database migrations:

```bash
php vendor/bin/contao-console contao:migrate
```

## Configuration

Enhanced labels are opt-in per user group. After installation:

1. Go to **System → User groups** in the Contao backend.
2. Open the user group that should see enhanced labels.
3. Enable the checkbox **Show enhanced labels** in the *Backend labels* section.
4. Save.

Members of that group will now see CSS ID, CSS class, and additional info in the backend labels. Admin users always see the enhanced labels regardless of group settings.

## License

LGPL-3.0-or-later
