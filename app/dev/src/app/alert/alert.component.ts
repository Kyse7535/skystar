import { Component, OnInit, Input, OnChanges, SimpleChanges, ViewChild } from '@angular/core';
import { SlideComponent } from '../slide/slide.component';

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.scss']
})
export class AlertComponent implements OnInit, OnChanges {
  @Input() color: String = 'primary'
  @Input() icon?: String;
  style: String = 'alert-primary';

  @ViewChild("slide") slide?: SlideComponent;

  constructor() { }

  toggle() {
    this?.slide?.toggle()
  }

  ngOnChanges(changes: SimpleChanges): void {
    switch(changes?.['color']?.currentValue) {
      case 'info':
        this.style = 'alert-info';
        break;
      case 'warning':
        this.style = 'alert-warning';
        break;
      case 'primary':
        this.style = 'alert-primary';
        break;
      case 'danger':
        this.style = 'alert-danger';
        break;
    }
  }

  ngOnInit(): void {
  }

}
