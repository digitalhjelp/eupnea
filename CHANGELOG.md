# Eupnea – Endringslogg

Alle vesentlige endringer i temaet er dokumentert her.
Format basert på [Keep a Changelog](https://keepachangelog.com/no/1.0.0/).

---

## [1.4.1] – 2026-05-24

### Endret
- **Bakgrunnsfarge** oppdatert til `#F9E5D7` (varm peach/sand)
- Nøytral-palett (gray-50 → gray-900) justert til varme sandtoner som harmonerer med bakgrunnsfargen
- `body` bruker nå CSS-variabelen `--color-bg` for bakgrunnen

---

## [1.4.0] – 2026-05-24

### Fikset
- **Gutenberg-konflikt med ACF:** Alle fire WordPress-filtre aktivert
  (`use_block_editor_for_post`, `use_block_editor_for_post_type`,
  `gutenberg_can_edit_post`, `gutenberg_can_edit_post_type`) med
  prioritet 999 – fungerer nå uavhengig av WordPress-versjon og plugins
- Admin-varsel på sider med direkte lenke til klassisk editor
  hvis Gutenberg likevel lastes

### Endret
- **Farger** oppdatert til Eupnea-merkevare:
  - Primær: `#1A3A2A` (mørk skoggrønn)
  - Sekundær: `#40916C` (mellomgrønn)
  - Accent: `#6BCB77` (lysegrønn)
- Grønntonede nøytrale farger (grå-paletten)
- Admin-panel oppdatert med grønn gradient

---

## [1.3.1] – 2026-05-24

### Lagt til
- **Motto-felt** på Ansatt CPT (under «Popup-innhold»-fanen)
- Motto vises som fremhevet sitat nederst i popup med teal venstrekant

---

## [1.3.0] – 2026-05-24

### Lagt til
- **Ansatt-popup:** Klikk på ansatt-kort åpner en modal med detaljert informasjon
- Nye ACF-felt på Ansatt CPT under fanen «Popup-innhold»:
  - Hvem er du?
  - Rolle
  - Mitt bidrag
  - Ansvar for
  - Styrker
- «Mer om →»-knapp vises automatisk på kort som har popup-innhold
- Popup er tilgjengelig (ARIA-attributter, fokus-felle, Escape-lukking)
- Mobil: popup glir opp som et bunnark (sheet)

### Endret
- Ansatt ACF-felt organisert i to faner: «Grunninfo» og «Popup-innhold»

---

## [1.2.0] – 2026-05-24

### Lagt til
- **Custom Post Types** med egne adminmenypunkter:
  - 👥 Ansatte
  - 🎓 Mentorer
  - 🏢 Partnere
  - 💬 Tilbakemeldinger
- ACF-felt for hvert CPT registrert i PHP
- Admin-kolonner med bilde, stilling og rekkefølge
- Tips om rekkefølge i CPT-editoren

### Fikset
- **Gutenberg-konflikt med ACF Flexible Content:** Klassisk editor
  aktiveres automatisk for sider og CPT-er – «Legg til modul»-knappen
  fungerer nå korrekt

### Endret
- Modulene Team, Mentorer, Partnere og Tilbakemeldinger henter nå
  data fra CPT-ene i stedet for ACF-repeater-felt
- Forenklet konfigurasjon i modulene (overskrift, kolonner, maks antall)

---

## [1.1.0] – 2026-05-24

### Lagt til
- Eget «Eupnea»-menypunkt i WordPress-adminpanelet med undermenyer:
  - Generelle innstillinger (farger, slagord, bunntekst)
  - Kontaktinformasjon (adresse, telefon, e-post, Google Maps)
  - Sosiale medier (Facebook, Instagram, LinkedIn, Twitter/X, YouTube)
  - Moduler & hjelp (oversikt og hurtigredigering)
- Hurtiglenker i admin-baren øverst på siden
- Dynamiske CSS-variabler – farger oppdateres umiddelbart uten å redigere kode
- ACF Options Pages for header- og footer-innstillinger

---

## [1.0.0] – 2026-05-24

### Første versjon

#### Tema-grunnlag
- WordPress 6.0+ med PHP 8.0+
- Responsivt design, mobil-first
- Google Fonts: Inter + DM Serif Display
- CSS custom properties (variabler) for hele designsystemet

#### ACF Flexible Content – 9 moduler
- 🖼️ **Hero** – bakgrunnsbilde/video, overlay, overskrift, CTA-knapper
- ⚡ **Tjenester** – kort-grid med ikon/emoji, tittel og beskrivelse
- 🏢 **Om oss** – to-kolonne med bilde, tekst og statistikk-teller
- 👥 **Ansatte / Team** – profilkort
- 🎓 **Mentorer** – mentorkort med tagger
- 🤝 **Partnere** – logo-grid eller scrollende marquee
- 💬 **Tilbakemeldinger** – grid, slider eller enkelt-sitat
- 🧭 **Hvorfor / Hvordan / Hvor** – tre-kolonne presentasjon
- 📞 **Kontakt** – kontaktinfo + skjema-shortcode

#### JavaScript-funksjonalitet
- Sticky header med blur-effekt ved scroll
- Mobil hamburger-meny med animasjon
- Scroll-inn-animasjoner (Intersection Observer)
- Teller-animasjon for statistikk
- Testimonials-slider med swipe-støtte
- Partners marquee med pause ved hover
- Smooth scroll for anker-lenker
