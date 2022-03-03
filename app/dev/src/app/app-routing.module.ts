import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AstroguessrComponent } from './astroguessr/astroguessr.component';
import { CarteComponent } from './carte/carte.component';
import { HomeComponent } from './home/home.component';
import { ResearchComponent } from './research/research.component';

const routes: Routes = [
  { path: "", component: HomeComponent, data: { title: '' } },
  { path: "rechercher", component: ResearchComponent, data: { title: 'Rechercher' } },
  { path: "carte", component: CarteComponent, data: { title: 'Carte' } },
  { path: "astroguessr", component: AstroguessrComponent, data: { title: 'Astroguessr' } }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
