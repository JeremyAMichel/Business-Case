import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AccueilComponent } from './pages/accueil/accueil.component';
import { ContactComponent } from './pages/contact/contact.component';
import { DetailedAnnonceComponent } from './pages/detailed-annonce/detailed-annonce.component';
import { ProfilComponent } from './pages/profil/profil.component';
import { QuiSommesNousComponent } from './pages/qui-sommes-nous/qui-sommes-nous.component';

const routes: Routes = [
  { path: '', component: AccueilComponent },
  { path: 'contact', component: ContactComponent },
  { path: 'annonce-details', component: DetailedAnnonceComponent },
  { path: 'profil', component: ProfilComponent },
  { path: 'qui-sommes-nous', component: QuiSommesNousComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
