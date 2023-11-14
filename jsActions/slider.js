class Slider {
    constructor(containerClassName, slideClassName) {
        this.slider = document.querySelector(`.${containerClassName}`);
        this.slides = document.querySelectorAll(`.${slideClassName}`);
        this.currentIndex = 0;
    }

    updateSlider() {
        const slideWidth = this.slides[0].offsetWidth;
        this.slider.style.transform = `translateX(-${this.currentIndex * slideWidth}px)`;
    }

    nextSlide() {
        if (this.currentIndex < this.slides.length - 1) {
            this.currentIndex++;
            this.updateSlider();
        }
    }

    prevSlide() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
            this.updateSlider();
        }
    }
}

// Create instances for each slider
const slider1 = new Slider("slider1", "product-slide1");
const slider2 = new Slider("slider2", "product-slide2");
const slider3 = new Slider("slider3", "product-slide3");
