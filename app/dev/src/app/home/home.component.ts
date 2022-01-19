import { Component, OnInit } from '@angular/core';
import { Container, Main, OutMode } from 'tsparticles';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  id = "ngParticles"
  /* or the classic JavaScript object */
  particlesOptions = {
    "background": {
      "color": {
        "value": "#3d3b37"
      },
      "position": "50% 50%",
      "repeat": "no-repeat",
      "size": "20%"
    },
    "fullScreen": {
      "zIndex": -1
    },
    "interactivity": {
      // "events": {
      //   "onClick": {
      //     "enable": true,
      //     "mode": "repulse"
      //   },
      //   "onHover": {
      //     "enable": true,
      //     "mode": "bubble"
      //   }
      // },
      "modes": {
        "bubble": {
          "distance": 250,
          "duration": 2,
          "opacity": 0,
          "size": 0
        },
        "grab": {
          "distance": 400
        },
        "repulse": {
          "distance": 400
        }
      }
    },
    "particles": {
      "color": {
        "value": "#ffffff"
      },
      "links": {
        "color": {
          "value": "#ffffff"
        },
        "distance": 150,
        "opacity": 0.4
      },
      "move": {
        "attract": {
          "rotate": {
            "x": 600,
            "y": 600
          }
        },
        "enable": true,
        "path": {},
        "outModes": OutMode.bounce,
        "random": true,
        "speed": 1,
        "spin": {}
      },
      "number": {
        "density": {
          "enable": true
        },
        "value": 160
      },
      "opacity": {
        "random": true,
        "value": {
          "min": 0,
          "max": 1
        },
        "animation": {
          "enable": true,
          "speed": 1,
          "minimumValue": 0
        }
      },
      "size": {
        "random": true,
        "value": {
          "min": 1,
          "max": 3
        },
        "animation": {
          "speed": 4,
          "minimumValue": 0.3
        }
      }
    }
  };
  constructor() { }

  ngOnInit(): void {
  }


particlesLoaded(container: Container): void {
    console.log(container);
}

particlesInit(main: Main): void {
    console.log(main);
    
    // Starting from 1.19.0 you can add custom presets or shape here, using the current tsParticles instance (main)
}

}
