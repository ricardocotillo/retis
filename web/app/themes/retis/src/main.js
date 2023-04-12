import './style.css'
import '@splidejs/splide/css'
import Alpine from 'alpinejs'
import Rellax from 'rellax'
import Splide from '@splidejs/splide'

const fire = (eventName, detail) => {
  const event = new CustomEvent(eventName, {detail})
  window.dispatchEvent(event)
}
window.fire = fire
window.Alpine = Alpine

const buyBtn = document.querySelector('#buy-btn')
const rentBtn = document.querySelector('#rent-btn')

buyBtn?.addEventListener('click', () => fire('application', 1))
rentBtn?.addEventListener('click', () => fire('application', 2))

window.retisApplicationForm = () => {
  return {
    step: 1,
    bType: 0,
    pType: 0,
    pool: 'either',
    init() {
      window.addEventListener('application', e => {
        this.bType = e.detail
        this.$nextTick(() => {
          this.$el.scrollIntoView({block: 'end', behavior: 'smooth'})
        })
      })
    },
  }
}

window.gallery = () => {
  return {
    splide: null,
    async onClick(id) {
      if (this.splide) this.splide.destroy(true)
      const res = await fetch(`/listing_content/${id}/`)
      const b = await res.text()
      this.$refs.popup.innerHTML = b
      this.$refs.popup.showModal()
      this.splide = new Splide('.splide', {
        type: 'loop',
        perPage: 1,
      })
      this.splide.mount()
    }
  }
}

Alpine.start()

new Rellax('.rellax')

setTimeout(() => {
  const b = document.querySelector('.banner-text')
  b?.classList.add('fadein')
}, 3000)