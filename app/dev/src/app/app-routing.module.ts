import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AstroguessrComponent } from './astroguessr/astroguessr.component';
import { CarteComponent } from './carte/carte.component';
import { HomeComponent } from './home/home.component';
import { ResearchComponent } from './research/research.component';

const routes: Routes = [
  { path: "", component: HomeComponent },
  { path: "rechercher", component: ResearchComponent },
  { path: "carte", component: CarteComponent },
  { path: "astroguessr", component: AstroguessrComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
