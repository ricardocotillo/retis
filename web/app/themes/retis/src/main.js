import './style.css'
import Alpine from 'alpinejs'
import Rellax from 'rellax'

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

Alpine.start()

const rellax = new Rellax('.rellax')