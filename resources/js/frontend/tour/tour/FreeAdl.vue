<template>
  <v-layout 
    column 
    wrap
    justify-content-center
  >
    <!-- <v-btn 
      dark 
      color="#aa282a"
      @click="addMoreGuide"
    >
      Добавить гида
    </v-btn>
    <v-btn 
      dark 
      color="#aa282a"
      @click="addMoreAttendant"
    >
      Добавить сопровождающего
    </v-btn> -->
    <v-layout 
      row 
      wrap
      justify-center
    >
      <v-btn 
        dark 
        color="#aa282a"
        @click="addFreeAdl"
      >
        "Бесплатный взрослый"
        <v-icon
          class="ml-2"
        >
          person_add
        </v-icon>
      </v-btn>
    </v-layout>
    <v-layout 
      v-if="freeAdls.length > 0"
      row 
      wrap
      justify-center
    >
      <v-flex
        v-for="adl in freeAdls"
        :key="adl.id"
        xs3
        lg2
        ma-2
      >
        <v-card 
          class="adl-card"
          :class="{'is-select' : adl.selected}"
          pa-3
        >
          <v-card-title primary-title>
            <div>
              <v-text-field
                v-model="adl.name"
                label="ФИО"
                append-outer-icon="person_outline"
                :dark="adl.selected"
                :disabled="adl.selected"
                class="mt-3"
                color="#aa282a"
              />
              <v-divider />
              <v-select
                v-model="adl.daysArray"
                :items="days"
                :dark="adl.selected"
                :disabled="adl.selected"
                multiple
                color="#aa282a"
                label="День тура"
                outline
                @change="daysSelected(adl)"
              />
              <v-text-field
                v-model="adl.about"
                :dark="adl.selected"
                :disabled="adl.selected"
                label="Описание"
                append-outer-icon="description"
                class="mt-3"
                color="#aa282a"
              />
            </div>
            <div
              v-show="!adl.selected"
            >
              <v-btn 
                color="#aa282a"
                dark
                flat
                @click="adl.showAdlDetails = !adl.showAdlDetails"
              >
                <v-icon
                  class="mr-2"
                >
                  hotel
                </v-icon>
                <v-icon>
                  fastfood
                </v-icon>
                <v-icon right>
                  expand_{{ adl.showAdlDetails ? 'less' : 'more' }}
                </v-icon>
              </v-btn>
              <div
                v-show="adl.showAdlDetails"  
              >
                <div>
                  <v-switch 
                    v-model="adl.options.hotel"
                    label="Проживание"
                    color="#aa282a" 
                  />
                  <v-switch 
                    v-model="adl.options.meal"
                    label="Питание"
                    color="#aa282a" 
                  />
                </div>
              </div>
            </div>
            <div
              v-show="!adl.selected"
            >
              <v-btn 
                color="#aa282a"
                dark
                flat
                @click="adl.showEvents = !adl.showEvents"
              >
                Экскурсии
                <v-icon right>
                  expand_{{ adl.showEvents ? 'less' : 'more' }}
                </v-icon>
              </v-btn>
              <div
                v-show="adl.showEvents"  
              >
                <v-switch 
                  v-for="(museum, i) in adl.museums"
                  :key="`${adl.id}-${i}`"
                  v-model="museum.selected"
                  :label="`День: ${museum.day}. ${museum.museum}: ${museum.event}. Цена: ${museum.price}`"
                  color="#aa282a" 
                />
              </div>
            </div>
          </v-card-title>
          <v-divider />
          <v-card-actions>
            <v-btn 
              v-if="!adl.selected"
              color="red"
              flat
              @click="remove(adl)"
            >
              Удалить
              <v-icon>close</v-icon>
            </v-btn>
            <v-spacer />
            <v-btn 
              color="#aa282a"
              flat
              :disabled="adl.name == ''"
              @click="choose(adl)"
            >
              {{ adl.selected ? 'Редактировать' : 'Сохранить' }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-layout>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'FreeAdl',
  data() {
    return {
      about: '',
      freeAdls: [],
      usedIds: 0,
    }
  },
  computed: {
    ...mapGetters([
      'getTour',
    ]),
    days: function() {
      let result = []
      for (let i = 1; i <= this.getTour.options.days; i++) {
        result.push(i)
      } 
      return result
    },
    museums() {
      let result = []
      this.getTour.museum.forEach((museum) => {
        let adlPrice = JSON.parse(museum.obj.extra).priceList.find((price) => {
          return price.customerName.includes('Взр')
        })
        result.push({
          museum: museum.museum.name,
          eventId: museum.obj.id,
          event: museum.obj.name,
          museumId: museum.museum.id,
          day: museum.obj.day,
          price: adlPrice.price,
          selected: false,
        })
      })
      return result
    },
  },
  mounted() {
    if (this.getTour.options.freeAdls != []) {
      this.getTour.options.freeAdls.forEach(adl => this.freeAdls.push({...adl}))
    }
    this.usedIds = this.freeAdls.length
  },
  methods: {
    ...mapActions([
      'updateFreeAdlsOptions',
    ]),
    addFreeAdl() {
      let adl = {
        // Ex.: TourId = 38, freeAdls.length = 2 => id = 383
        id: this.getTour.id.toString() + (this.usedIds + 1).toString(),
        name: '',
        day: NaN,
        daysArray: [],
        options: {
          hotel: false,
          meal: false,
        },
        showAdlDetails: false,
        showEvents: false,
        museums: [],
        selected: false,
        showDetailsInSummary: false,
        totalPrice: 0,
        totalPricePerSeat: 0,
        correction: 0,
        commission: 0,
        correctedPricePerSeat: 0,
        commissionPricePerSeat: 0,
      }
      this.museums.forEach((museum) => {
        adl.museums.push({...museum})
      })
      this.usedIds += 1
      this.freeAdls.push(adl)
    },
    daysSelected(adl) {
      adl.day = adl.daysArray.length
    },
    remove(adl) {
      this.freeAdls = this.freeAdls.filter(item => item.id != adl.id)
    },
    choose(adl) {
      adl.selected = !adl.selected
      this.updateFreeAdlsOptions(adl.selected ? adl : { delete: adl.id })
    },
  }
}
</script>

<style lang="scss" scoped>
.adl-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
</style>