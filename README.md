# Eupnea WordPress-tema

Modulbasert WordPress-tema med ACF Flexible Content og egne Custom Post Types for enkel administrasjon.

---

## 📋 Krav

- WordPress 6.0+
- PHP 8.0+
- [Advanced Custom Fields (ACF)](https://www.advancedcustomfields.com/) – gratis versjon

---

## 🚀 Installasjon

1. Last opp `eupnea`-mappen til `/wp-content/themes/eupnea/`
2. Aktiver temaet under **Utseende → Temaer**
3. Installer og aktiver **ACF**-pluginet
4. Gå til **Innstillinger → Lesing** og sett en statisk forside
5. Rediger forsiden og legg til moduler (se under)

---

## 🗂️ Adminpanel – menypunkter

Temaet legger til disse menyene i adminpanelet:

| Meny | Hva du gjør her |
|------|----------------|
| **Ansatte** | Legg til / rediger ansatte med bilde, stilling, bio og LinkedIn |
| **Mentorer** | Legg til / rediger mentorer med kompetanse og tagger |
| **Partnere** | Legg til partnere med logo og nettside |
| **Tilbakemeldinger** | Legg til sitater med stjerner og forfatterbilde |
| **Eupnea → Generelt** | Endre farger og slagord |
| **Eupnea → Kontakt** | Adresse, telefon, e-post, Google Maps |
| **Eupnea → Sosiale medier** | Facebook, Instagram, LinkedIn, m.fl. |

---

## 🧩 Slik legger du til moduler på forsiden

> **Viktig:** Temaet bruker klassisk editor for sider (Gutenberg er deaktivert for sider). ACF-feltene vises da korrekt.

1. Gå til **Sider** → klikk **Rediger** på forsiden
2. Scroll ned under tekstfeltet – du ser **«🧩 Sidebygger – Moduler»**
3. Klikk **«➕ Legg til modul»**
4. Velg ønsket modul fra listen
5. Fyll inn innstillinger (overskrift, stil osv.)
6. Klikk **Oppdater** for å lagre

**Rekkefølge:** Dra i håndtaket (≡) til venstre for å flytte moduler opp/ned.

---

## 🧩 Tilgjengelige moduler

| Modul | Hva du setter i modulen | Data fra |
|-------|------------------------|---------|
| 🖼️ **Hero** | Bilde/video, overskrift, CTA-knapper | Direkte i modulen |
| ⚡ **Tjenester** | Tjeneste-kort med ikon og tekst | Direkte i modulen |
| 🏢 **Om oss** | Bilde, tekst, statistikk | Direkte i modulen |
| 👥 **Ansatte** | Overskrift, antall kolonner | **Ansatte**-menyen |
| 🎓 **Mentorer** | Overskrift, maks antall | **Mentorer**-menyen |
| 🤝 **Partnere** | Overskrift, grid/marquee | **Partnere**-menyen |
| 💬 **Tilbakemeldinger** | Overskrift, grid/slider | **Tilbakemeldinger**-menyen |
| 🧭 **Hvorfor/Hvordan/Hvor** | Ikon, merkelapp, tittel og tekst | Direkte i modulen |
| 📞 **Kontakt** | Skjema-shortcode, kart | **Eupnea → Kontakt** |

---

## 👤 Legge til en ansatt

1. Klikk **Ansatte** i venstremenyen
2. Klikk **Legg til ansatt**
3. Skriv inn **navn** som sidetittel
4. Last opp **profilbilde** (Fremhevet bilde, øverst til høyre)
5. Fyll inn **Stilling**, **Bio**, **E-post** og **LinkedIn**
6. Sett **rekkefølge** under «Sidens attributter» (lavest vises først)
7. Publiser

---

## 🔢 Rekkefølge på ansatte / mentorer

Under redigering finner du **«Sidens attributter»** i høyre sidefelt.  
Endre **«Rekkefølge»**-feltet: `0` = vises først, `1` = neste, osv.

---

## 🎨 Farger

Gå til **Eupnea → Generelle innstillinger** for å endre:
- **Primærfarge** – mørk navy (standard `#0D3349`)
- **Sekundærfarge** – teal (standard `#14B8A6`)
- **Accentfarge** – amber/gul for CTA-knapper (standard `#F59E0B`)

---

## 📁 Filstruktur

```
eupnea/
├── functions.php           – Tema-oppsett, inkluderer alle filer
├── inc/
│   ├── post-types.php      – CPT: Ansatte, Mentorer, Partnere, Tilbakemeldinger
│   ├── acf-cpt-fields.php  – ACF-felt for CPT-ene
│   ├── acf-fields.php      – ACF Flexible Content-moduler
│   ├── acf-options.php     – ACF Options Pages
│   ├── admin-menu.php      – Eupnea admin-meny + innstillinger
│   ├── enqueue.php         – Skript og stilark
│   └── helpers.php         – Hjelpefunksjoner
├── modules/
│   ├── hero.php
│   ├── services.php
│   ├── about.php
│   ├── team.php            – Henter fra Ansatte CPT
│   ├── mentors.php         – Henter fra Mentorer CPT
│   ├── partners.php        – Henter fra Partnere CPT
│   ├── testimonials.php    – Henter fra Tilbakemeldinger CPT
│   ├── why-how-where.php
│   └── contact.php
└── assets/
    ├── css/main.css
    ├── css/admin.css
    └── js/main.js
```
