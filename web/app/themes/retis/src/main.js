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

const states = document.querySelectorAll('.state')
const stateModal = document.querySelector('#state-modal')
const propertyTypes = document.querySelectorAll('.property-type')
let state = null

states?.forEach(s => {
  s.addEventListener('click', () => {
    state = s.id
    stateModal?.showModal()
  })
})

propertyTypes?.forEach(p => {
  p.addEventListener('click', () => {
    const type = p.classList.item(p.classList.length - 1)
    location.href = `/location/${state}/?type=${type}`
  })
})

const requestBtns = document.querySelectorAll('.request-btn')
const requestModal = document.querySelector('#request-modal')
const propertyInput = document.querySelector('#property-input')

requestBtns?.forEach(r => {
  r.addEventListener('click', () => {
    requestModal?.showModal()
    propertyInput.value = r.dataset.id
  })
})