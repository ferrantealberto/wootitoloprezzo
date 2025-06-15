# 📦 Guida Installazione - Salient WooCommerce Product Display Enhancer

Questa guida completa ti aiuterà a installare e configurare il plugin **Salient WooCommerce Product Display Enhancer - Responsive** versione 2.0.0.

## 🚀 Installazione Rapida

### Prerequisiti
- ✅ WordPress 5.0 o superiore
- ✅ WooCommerce 3.0 o superiore  
- ✅ PHP 7.0 o superiore
- ✅ Tema Salient (consigliato ma non obbligatorio)

### Passo 1: Scarica i File
Assicurati di avere tutti questi file nella cartella del plugin:

```
salient-woocommerce-enhancer/
├── index.php                          # ⭐ File principale
├── config.php                         # ⚙️ Configurazione
├── uninstall.php                      # 🗑️ Script disinstallazione
├── css/
│   ├── admin.css                       # 🎨 Stili admin
│   └── salient-product-enhancer.css    # 📱 CSS responsive
├── js/
│   └── admin.js                        # ⚡ JavaScript admin
├── languages/
│   └── salient-woocommerce-enhancer.pot # 🌍 Traduzioni
├── README.md                           # 📖 Documentazione
└── INSTALLATION.md                     # 📋 Questa guida
```

### Passo 2: Caricamento File

#### Metodo 1: FTP/cPanel
1. **Comprimi** tutti i file in un archivio ZIP chiamato `salient-woocommerce-enhancer.zip`
2. **Carica** la cartella via FTP in `/wp-content/plugins/`
3. **Verifica** che la struttura sia: `/wp-content/plugins/salient-woocommerce-enhancer/index.php`

#### Metodo 2: Dashboard WordPress
1. **Comprimi** tutti i file in `salient-woocommerce-enhancer.zip`
2. Vai in **Plugin → Aggiungi nuovo → Carica plugin**
3. **Seleziona** il file ZIP e clicca "Installa ora"
4. **Attiva** il plugin dopo l'installazione

### Passo 3: Attivazione
1. Vai in **Plugin → Plugin installati**
2. Trova **"Salient WooCommerce Product Display Enhancer - Responsive"**
3. Clicca **"Attiva"**

✅ **Il plugin è ora attivo!**

## ⚙️ Configurazione Iniziale

### Accesso al Pannello di Controllo
1. Vai in **Impostazioni → Salient WooCommerce**
2. Vedrai un'interfaccia con 6 tab:
   - 🏷️ **Titolo Prodotto**
   - 💰 **Prezzo** 
   - 🎯 **Pulsante**
   - 📦 **Container**
   - 📱 **Responsive**
   - ⚙️ **Avanzate**

### Configurazione Base (5 minuti)

#### Tab Titolo Prodotto
```
✅ Font Size Desktop: 18px
✅ Font Size Tablet: 16px  
✅ Font Size Mobile: 14px
✅ Font Weight: Semi-Bold (600)
✅ Colore: #333333
✅ Allineamento: Centro
✅ Margine Inferiore: 8px
```

#### Tab Prezzo
```
✅ Font Size Desktop: 16px
✅ Font Size Tablet: 14px
✅ Font Size Mobile: 13px  
✅ Font Weight: Medium (500)
✅ Colore: #e74c3c
✅ Allineamento: Centro
✅ Margine Inferiore: 12px
```

#### Tab Pulsante
```
✅ Testo: "Vai al prodotto"
✅ Font Size Desktop: 14px
✅ Font Size Tablet: 13px
✅ Font Size Mobile: 12px
✅ Colore Sfondo: #3498db
✅ Colore Testo: #ffffff
✅ Colore Hover: #2980b9
✅ Raggio Bordo: 4px
✅ Padding H: 16px, V: 10px
✅ Allineamento: Centro
```

#### Tab Responsive  
```
✅ Abilita Responsive: ✓ ATTIVO
✅ Breakpoint Mobile: 768px
✅ Breakpoint Tablet: 1024px
```

#### Tab Avanzate
```
✅ Nascondi Elementi Originali: ✓ ATTIVO  
✅ CSS Personalizzato: (lascia vuoto per ora)
```

**💾 Clicca "Salva Impostazioni"**

## 🔧 Personalizzazione Avanzata

### Impostazioni per Dispositivi Specifici

#### 📱 Ottimizzazione Mobile
Per una migliore esperienza mobile:

```css
/* Nel tab CSS Personalizzato */
@media (max-width: 480px) {
    .salient-product-title {
        line-height: 1.2 !important;
        padding: 0 5px !important;
    }
    
    .salient-go-to-product {
        width: 100% !important;
        margin: 5px 0 !important;
    }
}
```

#### 💻 Ottimizzazione Desktop
Per desktop con schermi grandi:

```css
@media (min-width: 1200px) {
    .salient-custom-product-info {
        max-width: 90% !important;
        margin: 0 auto !important;
    }
}
```

### Personalizzazioni per Tema Salient

#### Integrazione con Nectar Slider
```css
/* Per prodotti in Nectar Slider */
.nectar-woo-flickity .salient-custom-product-info {
    position: relative !important;
    z-index: 10 !important;
}

.nectar-woo-flickity .salient-go-to-product {
    margin-top: 8px !important;
}
```

#### Compatibilità Salient Dark Mode
```css
/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .salient-product-title {
        color: #ffffff !important;
    }
    
    .salient-custom-product-info {
        background: rgba(255,255,255,0.05) !important;
        border-radius: 6px !important;
    }
}
```

## 🎨 Esempi di Stile

### Stile Moderno
```
Titolo: Font 20px, Weight 300, Colore #2c3e50
Prezzo: Font 18px, Weight 600, Colore #e67e22  
Pulsante: BG #1abc9c, Hover #16a085, Radius 25px
```

### Stile Classico  
```
Titolo: Font 16px, Weight 600, Colore #333333
Prezzo: Font 14px, Weight 500, Colore #c0392b
Pulsante: BG #34495e, Hover #2c3e50, Radius 3px
```

### Stile Minimale
```
Titolo: Font 15px, Weight 400, Colore #7f8c8d  
Prezzo: Font 14px, Weight 600, Colore #2c3e50
Pulsante: BG #ecf0f1, Text #2c3e50, Radius 0px
```

## 🐛 Risoluzione Problemi

### ❌ Problema: Plugin non si attiva
**Soluzione:**
1. Verifica che WooCommerce sia attivo
2. Controlla versione PHP (deve essere 7.0+)
3. Verifica permessi file (644 per file, 755 per cartelle)
4. Controlla log errori in `wp-content/debug.log`

### ❌ Problema: Stili non applicati
**Soluzione:**
1. **Svuota cache** (plugin cache, browser, CDN)
2. Verifica in **Tab Avanzate** che "Nascondi Elementi Originali" sia attivo
3. Controlla **Console Browser** per errori CSS
4. Testa con tema WordPress di default

### ❌ Problema: Layout rotto su mobile
**Soluzione:**
1. Vai in **Tab Responsive**
2. Verifica che "Abilita Responsive" sia ✓ attivo
3. Controlla breakpoint mobile (dovrebbe essere 768px)
4. Testa con **Chrome DevTools** modalità mobile

### ❌ Problema: Pulsanti non allineati
**Soluzione:**
1. **Reset** sezione pulsante (usa pulsante "Reset" nel tab)
2. Imposta **Allineamento** pulsante su "Centro"
3. Verifica **CSS personalizzato** per conflitti
4. Controlla che il tema non sovrascriva gli stili

### ❌ Problema: Anteprima non funziona
**Soluzione:**
1. **Ricarica** la pagina admin
2. Verifica che **JavaScript** sia abilitato
3. Controlla **Console Browser** per errori JS
4. Disattiva altri plugin temporaneamente

## 🔍 Testing e Debug

### Modalità Debug
Aggiungi a `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('SALIENT_WOO_DEBUG', true);
```

### Test Responsive
1. **Chrome DevTools**: F12 → Toggle Device Toolbar
2. Testa risoluzioni: 320px, 768px, 1024px, 1200px
3. Verifica orientamento landscape/portrait
4. Controlla touch targets (min 44px)

### Test Prestazioni
1. **GTmetrix** o **PageSpeed Insights**
2. Verifica caricamento CSS inline
3. Controlla compressione GZIP
4. Misura Largest Contentful Paint (LCP)

## 📋 Checklist Post-Installazione

### ✅ Verifica Funzionalità Base
- [ ] Plugin attivato senza errori
- [ ] Pannello admin accessibile
- [ ] Anteprima live funzionante  
- [ ] Salvataggio impostazioni OK
- [ ] CSS responsive applicato

### ✅ Test Visual
- [ ] Titoli prodotti visibili
- [ ] Prezzi formattati correttamente
- [ ] Pulsanti "Vai al prodotto" presenti
- [ ] Allineamento corretto
- [ ] Responsive su mobile/tablet

### ✅ Test Funzionale
- [ ] Click pulsante va alla pagina prodotto
- [ ] Nessun conflitto con Add to Cart
- [ ] Compatibilità con checkout
- [ ] Performance soddisfacenti
- [ ] SEO non compromesso

### ✅ Test Browser
- [ ] Chrome ✓
- [ ] Firefox ✓  
- [ ] Safari ✓
- [ ] Edge ✓
- [ ] Mobile Safari ✓
- [ ] Mobile Chrome ✓

## 🔄 Aggiornamenti Futuri

### Backup Pre-Aggiornamento
Prima di aggiornare:
1. **Backup** database completo
2. **Esporta** impostazioni plugin
3. **Backup** file tema child
4. **Test** su staging environment

### Processo Aggiornamento
1. **Disattiva** plugin
2. **Sostituisci** file plugin
3. **Riattiva** plugin
4. **Verifica** impostazioni conservate
5. **Test** funzionalità

## 🆘 Supporto

### Risorse Utili
- 📖 **Documentazione completa**: README.md
- 🐛 **Log errori**: `/wp-content/uploads/salient-woo-enhancer.log`
- 🔧 **Ispettore browser**: F12 per debug CSS/JS
- 📱 **Device testing**: Chrome DevTools

### Informazioni per Supporto
Quando richiedi aiuto, includi sempre:

```
WordPress Version: X.X.X
WooCommerce Version: X.X.X  
Theme: Nome e versione
PHP Version: X.X.X
Plugin Version: 2.0.0
Browser: Nome e versione
Device: Desktop/Mobile/Tablet
Error Messages: Copia esatto messaggio
```

### Debug Avanzato
Abilita debug e condividi:
```php
// In wp-config.php
define('SALIENT_WOO_DEBUG', true);

// Log location
/wp-content/uploads/salient-woo-enhancer.log
```

---

## 🎉 Congratulazioni!

Il tuo plugin **Salient WooCommerce Product Display Enhancer** è ora completamente installato e configurato! 

### Prossimi Passi:
1. 🎨 **Personalizza** gli stili secondo il tuo brand
2. 📱 **Testa** su diversi dispositivi  
3. 🚀 **Ottimizza** le performance
4. 📊 **Monitora** l'engagement sui prodotti

**✨ Buon lavoro con il tuo nuovo plugin responsive!**