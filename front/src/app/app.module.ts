import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './components/header/header.component';
import { MenuComponent } from './components/menu/menu.component';
import { SliderComponent } from './components/slider/slider.component';
import { AccueilComponent } from './pages/accueil/accueil.component';
import { ProfilComponent } from './pages/profil/profil.component';
import { QuiSommesNousComponent } from './pages/qui-sommes-nous/qui-sommes-nous.component';
import { ContactComponent } from './pages/contact/contact.component';
import { PubComponent } from './components/pub/pub.component';
import { AnnoncesComponent } from './components/annonces/annonces.component';
import { AnnonceComponent } from './components/annonce/annonce.component';
import { PaginationComponent } from './components/pagination/pagination.component';
import { FooterComponent } from './components/footer/footer.component';
import { ConnexionComponent } from './components/connexion/connexion.component';
import { MonCompteComponent } from './components/mon-compte/mon-compte.component';
import { DetailedAnnonceComponent } from './pages/detailed-annonce/detailed-annonce.component';
import { DetailedSliderComponent } from './components/detailed-slider/detailed-slider.component';
import { OtherAnnoncesComponent } from './components/other-annonces/other-annonces.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    MenuComponent,
    SliderComponent,
    AccueilComponent,
    ProfilComponent,
    QuiSommesNousComponent,
    ContactComponent,
    PubComponent,
    AnnoncesComponent,
    AnnonceComponent,
    PaginationComponent,
    FooterComponent,
    ConnexionComponent,
    MonCompteComponent,
    DetailedAnnonceComponent,
    DetailedSliderComponent,
    OtherAnnoncesComponent,
  ],
  imports: [BrowserModule, AppRoutingModule],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
