# Eupnea WordPress-tema

Modulbasert WordPress-tema med ACF Flexible Content. Alle seksjoner på siden kan enkelt oppdateres via WordPress-adminpanelet.

---

## 📋 Krav

- WordPress 6.0+
- PHP 8.0+
- [Advanced Custom Fields (ACF)](https://www.advancedcustomfields.com/) – gratis versjon fungerer

---

## 🚀 Installasjon

1. Last opp `eupnea`-mappen til `/wp-content/themes/eupnea/`
2. Aktiver temaet under **Utseende → Temaer**
3. Installer og aktiver ACF-pluginet
4. Gå til **Sider → Innstillinger for lesing** og sett en statisk forside
5. Rediger forsiden og bruk modulvelgeren i bunnen

---

## 🧩 Tilgjengelige moduler

| Modul | Layoutnavn | Beskrivelse |
|-------|-----------|-------------|
| 🖼️ Hero | `hero` | Stor velkomstseksjon med bilde/video, overskrift og CTA |
| ⚡ Tjenester | `services` | Kort-grid med ikon, tittel og beskrivelse |
| 🏢 Om oss | `about` | Tokolonne med tekst, statistikk og bilde |
| 👥 Team | `team` | Profilkort for ansatte med LinkedIn |
| 🎓 Mentorer | `mentors` | Mentorkort med kompetansetagger |
| 🤝 Partnere | `partners` | Logo-grid eller scrollende marquee |
| 💬 Tilbakemeldinger | `testimonials` | Sitater i grid, slider eller enkelt-sitat |
| 🧭 Hvorfor/Hvordan/Hvor | `why_how_where` | Tre-kolonne presentasjon med ikon |
| 📞 Kontakt | `contact` | Kontaktinfo, kart og skjema |

---

## ⚙️ Admin-meny

Temaet legger til en **«Eupnea»-meny** i WordPress-adminpanelet med:

| Submeny | Innhold |
|---------|---------|
| Generelt | Slagord, farger (primær/sekundær/accent) |
| Kontakt | Adresse, telefon, e-post, Google Maps |
| Sosiale medier | Facebook, Instagram, LinkedIn, Twitter/X, YouTube |
| Moduler & hjelp | Oversikt + hurtigredigering |

I tillegg legges det til en **«Eupnea»-snarvei i admin-baren** øverst på siden.

---

## 🎨 Farger

Bruk **Eupnea → Generelle innstillinger** for å endre tema-farger:

- **Primærfarge** – Mørk navy (`#0D3349`)
- **Sekundærfarge** – Teal (`#14B8A6`)
- **Accentfarge** – Amber/gul (`#F59E0B`) – brukes til CTA-knapper

Fargene blir dynamisk generert som CSS-variabler på alle sider.

---

## 📁 Filstruktur

```
eupnea/
├── style.css               – Tema-header
├── functions.php           – Tema-oppsett + includes
├── header.php              – Nettstedets topp
├── footer.php              – Bunntekst
├── front-page.php          – Forsidemal (bruker modules)
├── page.php                – Generisk sidemal
├── index.php               – Fallback
├── single.php              – Enkeltinnlegg
├── 404.php                 – 404-side
│
├── inc/
│   ├── acf-fields.php      – Alle ACF-felt registrert i PHP
│   ├── acf-options.php     – ACF Options Pages
│   ├── admin-menu.php      – Eupnea admin-meny + innstillinger
│   ├── enqueue.php         – Skript og stilark
│   └── helpers.php         – Hjelpefunksjoner
│
├── modules/
│   ├── hero.php
│   ├── services.php
│   ├── about.php
│   ├── team.php
│   ├── mentors.php
│   ├── partners.php
│   ├── testimonials.php
│   ├── why-how-where.php
│   └── contact.php
│
├── template-parts/
│   └── flexible-content.php – ACF-loop
│
└── assets/
    ├── css/
    │   ├── main.css         – Alle frontend-stiler
    │   └── admin.css        – Admin-panel stiler
    └── js/
        └── main.js          – Frontend-JavaScript
```

---

## 🔌 Støttede skjema-plugins

Kontakt-modulen fungerer med alle shortcode-baserte skjema-plugins:
- Contact Form 7: `[contact-form-7 id="123"]`
- Gravity Forms: `[gravityforms id="1"]`
- WPForms: `[wpforms id="123"]`

---

## 👨‍💻 Legge til en ny modul

1. Legg til layout i `inc/acf-fields.php` → `eupnea_get_all_layouts()`
2. Lag modul-filen i `modules/ditt-navn.php`
3. Registrer mapping i `template-parts/flexible-content.php`

---

*Tema laget for eupnea.no*
