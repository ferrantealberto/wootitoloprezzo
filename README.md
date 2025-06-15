# Salient WooCommerce Product Display Enhancer - Responsive

Un plugin WordPress avanzato per migliorare la visualizzazione dei prodotti WooCommerce nel tema Salient con controlli completi dal backend e design completamente responsive.

## 🚀 Caratteristiche Principali

### ✨ Controllo Completo dal Backend
- **Pannello di amministrazione intuitivo** con interfaccia a tab
- **Controlli separati per Desktop, Tablet e Mobile**
- **Anteprima live** delle modifiche
- **Auto-salvataggio** delle bozze
- **Reset rapido** per sezione
- **CSS personalizzato** integrato

### 📱 Design Completamente Responsive
- **Breakpoint personalizzabili** per mobile e tablet
- **Typography scalabile** con clamp() CSS
- **Grid system flessibile** con CSS Grid e Flexbox fallback
- **Ottimizzazione touch** per dispositivi mobili
- **Support per high-DPI displays**
- **Dark mode compatibility**

### 🎨 Personalizzazione Avanzata
- **Controllo completo del titolo**: dimensioni font, peso, colore, allineamento
- **Gestione prezzo personalizzata**: stili indipendenti e responsive
- **Pulsante configurabile**: testo, colori, dimensioni, padding, border-radius
- **Container settings**: padding, margini, larghezza massima
- **Allineamenti indipendenti** per ogni elemento

### 🔧 Integrazione Perfetta
- **Compatibilità completa** con tema Salient
- **Rimozione intelligente** elementi originali WooCommerce
- **Support WooCommerce Blocks**
- **Integrazione con Nectar Slider**
- **Accessibilità ottimizzata** (WCAG 2.1)

## 📋 Requisiti

- WordPress 5.0+
- WooCommerce 3.0+
- PHP 7.0+
- Tema Salient (consigliato)

## 🛠 Installazione

1. **Carica i file del plugin** nella cartella `/wp-content/plugins/salient-woocommerce-enhancer/`
2. **Attiva il plugin** dal pannello WordPress
3. **Vai in Impostazioni → Salient WooCommerce** per configurare
4. **Personalizza** le impostazioni secondo le tue esigenze

## 📁 Struttura File

```
salient-woocommerce-enhancer/
├── index.php                          # File principale del plugin
├── css/
│   ├── admin.css                       # Stili pannello admin
│   └── salient-product-enhancer.css    # CSS frontend responsive
├── js/
│   └── admin.js                        # JavaScript pannello admin
├── languages/
│   └── salient-woocommerce-enhancer.pot # File traduzioni
├── uninstall.php                       # Script disinstallazione
└── README.md                           # Documentazione
```

## ⚙️ Configurazione

### Tab Titolo Prodotto
- **Font Size**: Controllo separato per Desktop (18px), Tablet (16px), Mobile (14px)
- **Font Weight**: Da Light (300) a Bold (700)
- **Colore**: Color picker avanzato con anteprima hex
- **Allineamento**: Sinistra, Centro, Destra
- **Margine**: Controllo spacing inferiore

### Tab Prezzo
- **Font Size Responsive**: Dimensioni ottimizzate per ogni dispositivo
- **Font Weight**: Personalizzabile indipendentemente dal titolo
- **Colore**: Picker con anteprima live
- **Allineamento**: Controllo indipendente
- **Spacing**: Margine personalizzabile

### Tab Pulsante
- **Testo**: Completamente personalizzabile (default: "Vai al prodotto")
- **Font Size**: Responsive per tutti i dispositivi
- **Colori**: Background, testo, e hover separati
- **Border Radius**: Da 0 (quadrato) a 50px (rotondo)
- **Padding**: Controllo orizzontale e verticale
- **Margin**: Spaziatura dal pulsante "Aggiungi al carrello"
- **Allineamento**: Posizionamento del container pulsante

### Tab Container
- **Padding**: Spaziatura interna del container principale
- **Margin Top**: Distanza dall'immagine prodotto
- **Max Width**: Larghezza massima come percentuale (50-100%)

### Tab Responsive
- **Enable/Disable**: Toggle per attivare/disattivare CSS responsive
- **Mobile Breakpoint**: Punto di rottura per mobile (default: 768px)
- **Tablet Breakpoint**: Punto di rottura per tablet (default: 1024px)
- **Validazione automatica**: Controlla che mobile < tablet

### Tab Avanzate
- **Hide Original Elements**: Nasconde titolo e prezzo WooCommerce originali
- **Custom CSS**: Campo textarea per CSS personalizzato aggiuntivo

## 📱 Breakpoint Responsive

### Desktop (1025px+)
- Font sizes: Titolo 18px, Prezzo 16px, Pulsante 14px
- Layout: Griglia flessibile con Grid CSS
- Spacing: Completo secondo impostazioni

### Tablet (769px - 1024px)
- Font sizes: Titolo 16px, Prezzo 14px, Pulsante 13px
- Layout: Griglia adattiva
- Spacing: Leggermente ridotto

### Mobile (<=768px)
- Font sizes: Titolo 14px, Prezzo 13px, Pulsante 12px
- Layout: Stack verticale con pulsanti full-width
- Spacing: Ottimizzato per touch
- Min-height: 44px per elementi touch

### Small Mobile (<=480px)
- Font sizes: Ulteriormente ridotte
- Layout: Singola colonna
- Spacing: Minimizzato

### Extra Small (<=320px)
- Font sizes: Fisse per leggibilità
- Layout: Essenziale
- Griglia: Singola colonna forzata

## 🔧 Funzionalità Avanzate

### Auto-Save
- **Salvataggio automatico** ogni 5 secondi di inattività
- **Recovery delle bozze** al ricaricamento pagina
- **Indicatore visuale** di salvataggio

### Live Preview
- **Anteprima in tempo reale** di tutte le modifiche
- **Update automatico** durante la digitazione
- **Hover effects** simulati

### Reset System
- **Reset per sezione** con conferma
- **Ripristino ai default** per ogni tab
- **Preservazione di altre sezioni**

### Validation
- **Range validation** per valori numerici
- **Breakpoint validation** (mobile < tablet)
- **Color format validation**
- **CSS syntax checking** (base)

## 🎯 Ottimizzazioni Performance

### CSS Performance
- **Critical CSS inline** per above-the-fold
- **Non-blocking loading** per CSS secondario
- **Minificazione automatica** in produzione
- **Cache-friendly** selectors

### JavaScript Performance
- **Debounced events** per input
- **Efficient DOM queries** con caching
- **Minimal DOM manipulation**
- **Event delegation** pattern

### Responsive Performance
- **Mobile-first** CSS approach
- **Efficient media queries** con progressive enhancement
- **Touch optimization** con CSS containment
- **GPU acceleration** per animazioni

## 🔐 Sicurezza

### Input Sanitization
- **Escape output** con `esc_attr()`, `esc_html()`
- **Sanitize inputs** prima del salvataggio
- **Nonce verification** per form submission
- **Capability checks** per accesso admin

### CSS Security
- **CSS sanitization** per custom CSS
- **XSS prevention** in style output
- **Safe color values** validation

## 🌍 Compatibilità

### Browser Support
- **Chrome/Edge**: 88+
- **Firefox**: 85+
- **Safari**: 14+
- **iOS Safari**: 14+
- **Android Chrome**: 88+

### WordPress Compatibility
- **WordPress**: 5.0 - 6.4+
- **WooCommerce**: 3.0 - 8.0+
- **PHP**: 7.0 - 8.2+

### Theme Compatibility
- **Salient Theme**: Testato e ottimizzato
- **Altri temi**: Compatibilità base garantita
- **Child themes**: Completamente supportato

## 🐛 Troubleshooting

### Problemi Comuni

**Il plugin non si attiva**
- Verifica che WooCommerce sia attivo
- Controlla i requisiti PHP (7.0+)
- Verifica permessi file (644/755)

**Stili non applicati**
- Svuota cache del sito
- Verifica presenza file CSS
- Controlla conflitti con altri plugin

**Layout rotto su mobile**
- Verifica breakpoint settings
- Controlla CSS personalizzato per errori
- Testa con tema default

**Pulsanti non allineati**
- Resetta impostazioni sezione pulsante
- Verifica CSS tema per conflitti
- Controlla container max-width

### Debug Mode
Aggiungi a `wp-config.php` per debug avanzato:
```php
define('SALIENT_WOO_DEBUG', true);
```

## 📞 Supporto

Per supporto tecnico:
1. **Verifica** la documentazione
2. **Controlla** i problemi comuni
3. **Apri ticket** con dettagli specifici
4. **Includi** info sistema (WordPress, tema, plugin versioni)

## 📝 Changelog

### v2.0.0 (Corrente)
- ✨ Pannello admin completo con 6 tab
- 📱 Design completamente responsive
- 🎨 Controlli font separati per ogni dispositivo
- 🔧 Sistema reset e auto-save
- 🚀 Performance ottimizzate
- 🔐 Sicurezza migliorata

### v1.0.1 (Precedente)
- 🐛 Fix base compatibilità Salient
- 📝 CSS statico semplice

## 📄 Licenza

GPLv2 or later - https://www.gnu.org/licenses/gpl-2.0.html

## 👨‍💻 Sviluppo

**Autore**: Your Name  
**Version**: 2.0.0  
**Tested up to**: WordPress 6.4  
**WC tested up to**: 8.0

---

*Per la migliore esperienza, utilizza questo plugin con il tema Salient e WooCommerce aggiornati all'ultima versione.*