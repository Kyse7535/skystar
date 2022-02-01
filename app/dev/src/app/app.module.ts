import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AstroguessrComponent } from './astroguessr/astroguessr.component';
import { CarteComponent } from './carte/carte.component';
import { HomeComponent } from './home/home.component';
import { ResearchComponent } from './research/research.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatToolbarModule } from '@angular/material/toolbar';
import {MatButtonModule} from '@angular/material/button';
import { NgParticlesModule } from 'ng-particles';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    ResearchComponent,
    CarteComponent,
    AstroguessrComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatToolbarModule,
    MatButtonModule,
    NgParticlesModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
