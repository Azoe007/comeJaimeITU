# Structure des Assets et Compilation SCSS

## Structure des répertoires

```
public/assets/
├── css/
│   ├── animate.css               (animations CSS)
│   ├── bootstrap.min.css         (framework Bootstrap)
│   ├── owl.carousel.min.css      (carrousel)
│   ├── owl.theme.default.min.css (thème carrousel)
│   ├── magnific-popup.css        (lightbox)
│   ├── bootstrap-datepicker.css  (sélecteur de date)
│   ├── jquery.timepicker.css     (sélecteur d'heure)
│   ├── flaticon.css              (icônes)
│   ├── style.css                 (styles template)
│   └── auth.css                  (styles authentification - généré depuis SCSS)
├── js/
│   ├── jquery.min.js             (jQuery)
│   ├── popper.min.js             (Popper.js pour Bootstrap)
│   └── bootstrap.min.js          (Bootstrap JS)
├── images/
│   └── bg_2.jpg                  (image de fond hero)
├── fonts/
│   └── (polices personnalisées)
├── scss/
│   └── auth.scss                 (source SCSS pour styles auth)
└── README.md                     (ce fichier)
```

## Structure des Vues

```
app/Views/
├── layouts/
│   └── auth.php                  (layout principal pour toutes les pages auth)
└── auth/
    ├── login.php                 (page de connexion)
    ├── register_step1.php        (inscription - étape 1)
    └── register_step2.php        (inscription - étape 2)
```

## Fichiers SCSS

### public/assets/scss/auth.scss
Contient tous les styles pour les pages d'authentification :
- Styles des formulaires avec états hover et focus
- Styles des boutons avec transitions
- Styles des alertes (succès/erreur)
- Design responsif (mobile/tablette/desktop)
- Variables de couleurs pour personnalisation facile

### Variables disponibles
```scss
$primary-color: #13a06d;      // Vert principal
$secondary-color: #667eea;    // Accent secondaire
$danger-color: #dc3545;       // Couleur erreur
$light-bg: #f8f9fa;           // Fond clair
$border-color: #e0e0e0;       // Couleur bordures
$text-muted: #6c757d;         // Texte atténué
```

## Compilation SCSS vers CSS

### Option 1 : VS Code Live Sass Compiler
1. Installer l'extension "Live Sass Compiler"
2. Clic-droit sur `public/assets/scss/auth.scss`
3. Sélectionner "Watch Sass"
4. Les fichiers SCSS se compilent automatiquement en CSS

### Option 2 : Ligne de commande (Node-sass)
```bash
# Installation globale
npm install -g node-sass

# Compiler un fichier
node-sass public/assets/scss/auth.scss -o public/assets/css/

# Surveiller les modifications
node-sass -w public/assets/scss/ -o public/assets/css/
```

### Option 3 : Dart Sass (recommandé)
```bash
# Installation globale
npm install -g sass

# Compiler et surveiller
sass --watch public/assets/scss:public/assets/css
```

## Utilisation des CSS dans les Vues

Tous les fichiers d'authentification utilisent le layout principal qui inclut :
- Framework Bootstrap
- Icônes Font Awesome
- Styles du template (style.css)
- Styles personnalisés (auth.css)

```html
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
```

## Personnalisation des styles

Pour modifier les styles :

1. Éditer `public/assets/scss/auth.scss`
2. Modifier les variables SCSS :
   - `$primary-color` - Couleur verte principale
   - `$secondary-color` - Accent secondaire
   - `$danger-color` - Couleur erreur/danger
   - `$text-muted` - Couleur texte atténué

3. Compiler en CSS (automatiquement ou manuellement)
4. Les styles s'appliquent sur toutes les pages auth

## Ajouter des partials SCSS

Pour une meilleure organisation, créer des fichiers SCSS séparés :

```
public/assets/scss/
├── auth.scss            (fichier principal)
├── _variables.scss      (couleurs, tailles, breakpoints)
├── _forms.scss          (styles formulaires)
├── _buttons.scss        (styles boutons)
└── _responsive.scss     (media queries)
```

Puis les importer dans auth.scss :
```scss
@import 'variables';
@import 'forms';
@import 'buttons';
@import 'responsive';
```

## Points importants

- Le layout `app/Views/layouts/auth.php` est le template de base pour toutes les pages auth
- Toutes les pages étendent ce layout avec `<?= $this->extend('layouts/auth') ?>`
- Le contenu s'affiche dans la section dédiée avec `<?= $this->renderSection('content') ?>`
- Cette approche élimine la duplication de code et facilite la maintenance
- Tous les fichiers CSS et JS proviennent maintenant de `public/assets/` (pas du dossier `template/`)

## Fichiers CSS/JS disponibles

### CSS
- `animate.css` - Animations CSS
- `bootstrap.min.css` - Framework CSS
- `owl.carousel.min.css` - Carrousel
- `magnific-popup.css` - Lightbox/galerie
- `flaticon.css` - Ensemble d'icônes
- `style.css` - Styles template principaux
- `auth.css` - Styles authentification

### JavaScript
- `jquery.min.js` - jQuery 3.2.1
- `popper.min.js` - Popper pour tooltips/dropdowns
- `bootstrap.min.js` - Bootstrap JS

## Notes de développement

- Ne pas éditer les fichiers CSS directement, utiliser les SCSS
- La recompilation SCSS crée automatiquement le CSS dans le bon dossier
- Garder les fichiers du template comme référence, mais toujours modifier depuis assets
- Pour une meilleure performance, ajouter un processus de minification en production

