<template>
  <div>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <div class="title grey--text">
          Тур: {{ getTour.options.name }}, количество туристов: {{ getTour.qnt }}
        </div>
      </v-flex>  
    </v-layout>
    <v-layout 
      row 
      wrap
    >
      <v-spacer />
      <v-btn 
        v-if="getEditMode"
        dark
        color="#aa282a"
        @click="reCalcTour"
      >
        Пересчитать весь тур
      </v-btn>  
    </v-layout>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <table class="summary">
          <thead>
            <th>
              Услуга
            </th>
            <th>
              Стоимость
              <br>
              <v-select
                v-model="currentCustomerType"
                :items="getCurrentTourCustomers"
                item-value="id"
                item-text="name"
                label="Тип туриста"
                @change="customerChanged"
              />
            </th>
            <th>
              Наценка, %
              <v-text-field
                v-model="correctionToAll"
                label="На все"
                mask="###"
                outline
                @input="inputCorrection"
              /> 
            </th>
            <th>
              Нетто
            </th>
            <th
              v-show="!commissionManualMode"
            >
              Комиссия, %
              <v-text-field
                v-model="commissionToAll"
                label="На все"
                mask="###"
                outline
                @input="inputCommission"
              /> 
            </th>
            <th
              v-show="!commissionManualMode"
            >
              Итого
              <br>
            </th>
          </thead>
          <tbody>
            <tr v-if="getTour.transport.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Транспорт
              </td>
            </tr>
            <tr 
              v-for="(transport, i) in getTour.transport"
              :key="`T-${i}`"
            >
              <td>
                {{ transport.transport.name }}:
                {{ transport.obj.name }}.
                <br>
                <div class="body-1 grey--text">
                  Цена: {{ transport.obj.price }}, за {{ transport.obj.duration.hours }} часов.
                  <br>
                  Мест: {{ JSON.parse(transport.obj.extra).scheme.totalPassengersCount }}
                </div>
              </td>
              <td class="price">
                {{ transport.pricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    Стоимость за одного человека:
                    {{ transport.obj.price }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="transport.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(transport.correctedPricePerSeat) }}  
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="transport.commission"
                  name="commission"
                  @input="commissPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(transport.commissionPricePerSeat) }}
              </td>
            </tr>
            <tr v-if="getTour.museum.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Экскурсии
              </td>
            </tr>
            <tr 
              v-for="(event, i) in getTour.museum"
              :key="`M-${i}`"
            >
              <td>
                {{ event.museum.name }}:
                <br>
                {{ event.obj.name }}
                <div class="body-1 grey--text">
                  {{ customerName(event) }}
                  <br>
                  День: {{ event.obj.day }}
                </div>
              </td>
              <td class="price">
                {{ eventPrice(event) }}
              </td>
              <td>
                <v-text-field
                  v-model="event.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(event.correctedPrice) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="event.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(event.commissionPrice) }}
              </td>
            </tr>
            <tr v-if="getTour.museumCustomOrder.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Заказ-наряды
              </td>
            </tr>
            <tr 
              v-for="(order, i) in getTour.museumCustomOrder"
              :key="`CO-${i}`"
            >
              <td>
                {{ order.museum.name }}:
                <br>
                {{ order.obj.name }}
                <div class="body-1 grey--text">
                  День: {{ order.obj.day }}
                </div>
                <div class="body-1 grey--text">
                  Цена: {{ JSON.parse(order.obj.extra).price }}
                </div>
                <div class="body-1 grey--text">
                  Количество: {{ order.obj.count }}
                </div>
              </td>
              <td class="price">
                {{ order.pricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    Стоимость за одного человека:
                    {{ JSON.parse(order.obj.extra).price * order.obj.count }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="order.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(order.correctedPricePerSeat) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="order.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(order.commissionPricePerSeat) }}
              </td>
            </tr>
            <tr v-if="getTour.hotel.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Размещение
              </td>
            </tr>
            <tr 
              v-for="(hotel, i) in getTour.hotel"
              :key="`H-${i}`"
            >
              <td>
                {{ hotel.hotel.name }}:
                <br>
                {{ hotel.obj.name }}
                <br>
                <div class="body-1 grey--text">
                  Дни: {{ hotel.obj.daysArray }}
                  <br>
                  Стандартное размещение
                  <!-- <br>
                  Цена: {{ JSON.parse(hotel.obj.extra).priceList.standard }} -->
                </div>
              </td>
              <td class="price">
                {{ getHotelPrice(hotel) }}
              </td>
              <td>
                <v-text-field
                  v-model="hotel.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(hotel.correctedPrice) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="hotel.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(hotel.commissionPrice) }}
              </td>
            </tr>
            <tr v-if="getTour.meal.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Питание
              </td>
            </tr>
            <tr 
              v-for="(meal, i) in getTour.meal"
              :key="`Meal-${i}`"
            >
              <td>
                {{ meal.meal.name }}:
                <br>
                {{ meal.obj.name }}
                <br>
                <div class="body-1 grey--text">
                  Описание: {{ meal.obj.description }}, {{ meal.obj.price }} руб.
                  <br>
                  Дни: {{ meal.obj.daysArray }}
                </div>
              </td>
              <td class="price">
                {{ meal.obj.totalPrice }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    {{ meal.obj.price }} руб. * {{ meal.obj.day }} дн.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="meal.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(meal.correctedPrice) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="meal.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(meal.commissionPrice) }}
              </td>
            </tr>
            <tr v-if="getTour.guide.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Гиды
              </td>
            </tr>
            <tr 
              v-for="(guide, i) in getTour.guide"
              :key="`G-${i}`"
            >
              <td>
                {{ guide.guide.name }}:
                <div class="body-1 grey--text">
                  Цена: {{ guide.guide.totalPrice }}
                </div>
              </td>
              <td class="price">
                {{ guide.pricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    Стоимость за одного человека:
                    {{ guide.guide.totalPrice }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="guide.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(guide.correctedPricePerSeat) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="guide.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(guide.commissionPricePerSeat) }}
              </td>
            </tr>
            <tr v-if="getTour.attendant.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Сопровождающие
              </td>
            </tr>
            <tr 
              v-for="(attendant, i) in getTour.attendant"
              :key="`A-${i}`"
            >
              <td>
                {{ attendant.attendant.name }}:
              </td>
              <td class="price">
                {{ attendant.pricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    Стоимость за одного человека:
                    {{ attendant.attendant.totalPrice }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="attendant.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(attendant.correctedPricePerSeat) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="attendant.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(attendant.commissionPricePerSeat) }}
              </td>
            </tr>
            <tr v-if="getTour.customPrice.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Доп.услуги
              </td>
            </tr>
            <tr 
              v-for="(price, i) in getTour.customPrice"
              :key="`CP-${i}`"
            >
              <td>
                {{ price.name }}
              </td>
              <td class="price">
                {{ price.pricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    Стоимость за одного человека:
                    {{ price.value }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="price.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(price.correctedPricePerSeat) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="price.commission"
                  name="commission"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ parseInt(price.commissionPricePerSeat) }}
              </td>
            </tr>
            <tr v-if="getTour.options.drivers != 0 || getTour.guide.length != 0 || getTour.attendant.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
                style="background-color: #f8f8f8;"
              >
                Персонал
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="showStaff = !showStaff"
                >
                  <v-icon>
                    expand_{{ showStaff ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
                <v-alert
                  v-if="getStaffErrors.show"
                  :value="true"
                  color="orange"
                  icon="priority_high"
                >
                  <p
                    v-if="getStaffErrors.noHotel.length > 0"
                    class="body-2"
                  >
                    <v-icon
                      color="white"
                      class="mr-2"
                    >
                      hotel
                    </v-icon>
                    Не выбран отель на нужную ночь для:
                    <ul style="list-style: none;">
                      <li
                        v-for="(error, i) in getStaffErrors.noHotel"
                        :key="`${error.name}-${i}`"
                      >
                        {{ error.name }}, ночь: {{ error.day }}
                      </li>
                    </ul>
                  </p>
                  <p
                    v-if="getStaffErrors.noMeal.length > 0"
                    class="body-2"
                  >
                    <v-icon
                      color="white"
                      class="mr-2"
                    >
                      fastfood
                    </v-icon>
                    Не выбрано питание на нужный день для:
                    <ul style="list-style: none;">
                      <li
                        v-for="(error, i) in getStaffErrors.noMeal"
                        :key="`${error.name}-${i}`"
                      >
                        {{ error.name }}, ночь: {{ error.day }}
                      </li>
                    </ul>
                  </p>
                </v-alert>
              </td>
            </tr>
            <!-- Driver -->
            <tr v-show="showStaff">
              <td
                v-if="getTour.options.drivers != []"
                class="text-xs-center" 
                colspan="6"
              >
                Водители
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="showDrivers = !showDrivers"
                >
                  <v-icon>
                    expand_{{ showDrivers ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
              </td>
            </tr>
            <tr
              v-for="(driver, i) in getTour.options.drivers"
              v-show="showDrivers && showStaff"
              :key="`Driver-${i}`"
            >
              <td>
                {{ driver.busName }}. 
                <br>
                Водитель {{ driver.driver }}
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="driver.showDetails = !driver.showDetails"
                >
                  <v-icon>
                    expand_{{ driver.showDetails ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
                <div
                  v-if="driver.showDetails"
                >
                  <div 
                    v-if="driver.hotelPrice"
                  >
                    <v-divider />
                    Проживание: 
                    <div 
                      v-for="(room, r) in driver.hotelPrice"
                      :key="`Room-${r}`"
                    >
                      Ночь: {{ room.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ room.hotelName }}, {{ room.roomName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        <div v-if="!driver.isHotelSngl">
                          Цена (в двухместном): {{ room.hotelStdPrice }}
                        </div>
                        <div v-if="driver.isHotelSngl">
                          Цена (сингл): {{ room.hotelSnglPrice }}
                        </div>
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="driver.mealPrice"
                  >
                    <v-divider />
                    Питание:
                    <div
                      v-for="(meal, m) in driver.mealPrice"
                      :key="`Meal-${m}`"
                    >
                      День: {{ meal.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ meal.mealName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        Цена: {{ meal.mealPrice }}
                      </span>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                {{ driver.totalPricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    {{ driver.totalPrice }} / 
                    {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="driver.correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ driver.correctedPricePerSeat }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="driver.commission"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ driver.commissionPricePerSeat }}
              </td>
            </tr>
            <!-- Guide -->
            <tr v-show="showStaff">
              <td
                v-if="getTour.guide.length != 0"
                class="text-xs-center" 
                colspan="6"
              >
                Гиды
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="showGuides = !showGuides"
                >
                  <v-icon>
                    expand_{{ showGuides ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
              </td>
            </tr>
            <tr
              v-for="(guide, i) in getTour.guide"
              v-show="showGuides && showStaff"
              :key="`Guide-${i}`"
            >
              <td>
                {{ guide.guide.name }}
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="guide.showDetails = !guide.showDetails"
                >
                  <v-icon>
                    expand_{{ guide.showDetails ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
                <div
                  v-show="guide.showDetails"
                >
                  <div
                    v-if="guide.guide.options.hotel"
                  >
                    <v-divider />
                    Проживание: 
                    <div 
                      v-for="(room, r) in guide.hotelPrice"
                      :key="`Room-${r}`"
                    >
                      Ночь: {{ room.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ room.hotelName }}, {{ room.roomName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        <div v-if="!guide.guide.options.isHotelSngl">
                          Цена (в двухместном): {{ room.hotelStdPrice }}
                        </div>
                        <div v-if="guide.guide.options.isHotelSngl">
                          Цена (сингл): {{ room.hotelSnglPrice }}
                        </div>
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="guide.mealPrice"
                  >
                    <v-divider />
                    Питание:
                    <div
                      v-for="(meal, m) in guide.mealPrice"
                      :key="`Meal-${m}`"
                    >
                      День: {{ meal.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ meal.mealName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        Цена: {{ meal.mealPrice }}
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="guide.guide.events.length > 0"
                  >
                    <v-divider />
                    Экскурсии:
                    <div
                      v-for="(event, e) in guide.guide.events"
                      :key="`Event-${e}`"
                    >
                      День: {{ event.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ event.museum }}, {{ event.event }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        Цена: {{ event.price }}
                      </span>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                {{ guide.guide.options.totalPricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    {{ guide.guide.options.totalPrice }} / 
                    {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="guide.guide.options.correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ guide.guide.options.correctedPricePerSeat }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="guide.guide.options.commission"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ guide.guide.options.commissionPricePerSeat }}
              </td>
            </tr>
            <!-- Attendant -->
            <tr v-show="showStaff">
              <td
                v-if="getTour.guide.length != 0"
                class="text-xs-center" 
                colspan="6"
              >
                Сопровождающие
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="showAttendant = !showAttendant"
                >
                  <v-icon>
                    expand_{{ showAttendant ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
              </td>
            </tr>
            <tr
              v-for="(attendant, i) in getTour.attendant"
              v-show="showAttendant && showStaff"
              :key="`Attendant-${i}`"
            >
              <td>
                {{ attendant.attendant.name }}
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="attendant.showDetails = !attendant.showDetails"
                >
                  <v-icon>
                    expand_{{ attendant.showDetails ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
                <div
                  v-show="attendant.showDetails"
                >
                  <div
                    v-if="attendant.attendant.options.hotel"
                  >
                    <v-divider />
                    Проживание: 
                    <div 
                      v-for="(room, r) in attendant.hotelPrice"
                      :key="`Room-${r}`"
                    >
                      Ночь: {{ room.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ room.hotelName }}, {{ room.roomName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        <div v-if="!attendant.attendant.options.isHotelSngl">
                          Цена (в двухместном): {{ room.hotelStdPrice }}
                        </div>
                        <div v-if="attendant.attendant.options.isHotelSngl">
                          Цена (сингл): {{ room.hotelSnglPrice }}
                        </div>
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="attendant.mealPrice"
                  >
                    <v-divider />
                    Питание:
                    <div
                      v-for="(meal, m) in attendant.mealPrice"
                      :key="`Meal-${m}`"
                    >
                      День: {{ meal.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ meal.mealName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        Цена: {{ meal.mealPrice }}
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="attendant.attendant.events.length > 0"
                  >
                    <v-divider />
                    Экскурсии:
                    <div
                      v-for="(event, e) in attendant.attendant.events"
                      :key="`AttendantEvent-${e}`"
                    >
                      День: {{ event.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ event.museum }}, {{ event.event }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        Цена: {{ event.price }}
                      </span>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                {{ attendant.attendant.options.totalPricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    {{ attendant.attendant.options.totalPrice }} / 
                    {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="attendant.attendant.options.correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ attendant.attendant.options.correctedPricePerSeat }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="attendant.attendant.options.commission"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ attendant.attendant.options.commissionPricePerSeat }}
              </td>
            </tr>
            <!-- Free adls -->
            <tr v-if="getTour.options.freeAdls != 0">
              <td
                class="text-xs-center" 
                colspan="6"
                style="background-color: #f8f8f8;"
              >
                "Бесплатные взрослые"
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="showFreeAdls = !showFreeAdls"
                >
                  <v-icon>
                    expand_{{ showFreeAdls ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
                <v-alert
                  v-if="getFreeAdlErrors.show"
                  :value="true"
                  color="orange"
                  icon="priority_high"
                >
                  <p
                    v-if="getFreeAdlErrors.noHotel.length > 0"
                    class="body-2"
                  >
                    <v-icon
                      color="white"
                      class="mr-2"
                    >
                      hotel
                    </v-icon>
                    Не выбран отель на нужную Ночь для:
                    <ul style="list-style: none;">
                      <li
                        v-for="(error, i) in getFreeAdlErrors.noHotel"
                        :key="`${error.name}-${i}`"
                      >
                        {{ error.name }}, ночь: {{ error.day }}
                      </li>
                    </ul>
                  </p>
                  <p
                    v-if="getFreeAdlErrors.noMeal.length > 0"
                    class="body-2"
                  >
                    <v-icon
                      color="white"
                      class="mr-2"
                    >
                      fastfood
                    </v-icon>
                    Не выбрано питание на нужный день для:
                    <ul style="list-style: none;">
                      <li
                        v-for="(error, i) in getFreeAdlErrors.noMeal"
                        :key="`${error.name}-${i}`"
                      >
                        {{ error.name }}, день: {{ error.day }}
                      </li>
                    </ul>
                  </p>
                </v-alert>
              </td>
            </tr>
            <tr
              v-for="(freeAdl, i) in getTour.options.freeAdls"
              v-show="showFreeAdls"
              :key="`FreeAdl-${i}`"
            >
              <td>
                {{ freeAdl.name }}
                <v-btn 
                  color="#aa282a"
                  fab
                  flat
                  @click="freeAdl.showDetailsInSummary = !freeAdl.showDetailsInSummary"
                >
                  <v-icon>
                    expand_{{ freeAdl.showDetailsInSummary ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
                <div
                  v-show="freeAdl.showDetailsInSummary"
                >
                  <div
                    v-if="freeAdl.options.hotel"
                  >
                    <v-divider />
                    Проживание: 
                    <div 
                      v-for="(room, r) in freeAdl.hotelPrice"
                      :key="`FreeAdlRoom-${r}`"
                    >
                      Ночь: {{ room.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ room.hotelName }}, {{ room.roomName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        <div v-if="!freeAdl.options.isHotelSngl">
                          Цена (в двухместном): {{ room.hotelStdPrice }}
                        </div>
                        <div v-if="freeAdl.options.isHotelSngl">
                          Цена (сингл): {{ room.hotelSnglPrice }}
                        </div>
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="freeAdl.mealPrice"
                  >
                    <v-divider />
                    Питание:
                    <div
                      v-for="(meal, m) in freeAdl.mealPrice"
                      :key="`FreeAdlMeal-${m}`"
                    >
                      День: {{ meal.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ meal.mealName }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        Цена: {{ meal.mealPrice }}
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="freeAdl.museums.length > 0"
                  >
                    <v-divider />
                    Экскурсии:
                    <div
                      v-for="(event, e) in freeAdl.museums"
                      :key="`FreeAdl-${e}`"
                    >
                      День: {{ event.day }}
                      <br>
                      <span class="body-1 grey--text">
                        {{ event.museum }}, {{ event.event }}
                      </span>
                      <br>
                      <span class="body-1 grey--text">
                        Цена: {{ event.price }}
                      </span>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                {{ freeAdl.totalPricePerSeat }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon 
                      color="grey"
                      v-on="on"
                    >
                      info
                    </v-icon>
                  </template>
                  <span>
                    {{ freeAdl.totalPrice }} / 
                    {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="freeAdl.correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ freeAdl.correctedPricePerSeat }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                <v-text-field
                  v-model="freeAdl.commission"
                  @input="correctPrice"
                />
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ freeAdl.commissionPricePerSeat }}
              </td>
            </tr>
            <tr>
              <td>
                Итого: 
                <div class="body-1 grey--text">
                  Тип туриста: {{ (getCurrentTourCustomers.find(c => c.id == currentCustomerType)).name }}
                </div>
              </td>
              <td>
                {{ getTour.totalPrice }}
              </td>
              <td>
                Наценка, %
                <v-text-field
                  v-model="correctionToAll"
                  label="На все"
                  mask="###"
                  outline
                  @input="inputCorrection"
                /> 
              </td>
              <td>
                {{ (getTour.correctedPrice) }}
              </td>
              <td
                v-show="!commissionManualMode"
              >
                Комиссия, %
                <v-text-field
                  v-model="commissionToAll"
                  label="На все"
                  mask="###"
                  outline
                  @input="inputCommission"
                /> 
              </td>
              <td
                v-show="!commissionManualMode"
              >
                {{ getTour.commissionPrice }}
              </td>
            </tr>
          </tbody>
        </table>
      </v-flex>
    </v-layout>
    <v-divider />
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <table class="summary">
          <tr v-if="getTour.extraEvents != 0">
            <td
              class="text-xs-center" 
              colspan="6"
            >
              Допы
            </td>
          </tr>
          <tr 
            v-for="(event, i) in getTour.extraEvents"
            :key="`EE-${i}`"
          >
            <td>
              {{ event.museum.name }}:
              <br>
              {{ event.obj.name }}
              <div class="body-1 grey--text">
                {{ customerName(event) }}
                <br>
                День: {{ event.day }}
              </div>
            </td>
            <td class="price">
              {{ eventPrice(event) }}
            </td>
            <td>
              <v-text-field
                v-model="event.correction"
                name="correction"
                @input="correctPrice"
              />
            </td>
            <td>
              {{ parseInt(event.correctedPrice) }}
            </td>
            <td
              v-show="!commissionManualMode"
            >
              <v-text-field
                v-model="event.commission"
                name="commision"
                @input="correctPrice"
              />
            </td>
            <td
              v-show="!commissionManualMode"
            >
              {{ parseInt(event.commissionPrice) }}
            </td>
          </tr>
        </table>
      </v-flex>
    </v-layout>
    <v-divider />
    <v-layout
      row
      wrap
      justify-center
    >
      <v-flex
        xs6
        md3
        lg2
      >
        <v-switch
          v-model="commissionManualMode"
          color="#aa282a"
          label="Комиссия вручную"
        />
        <v-text-field
          v-if="commissionManualMode"
          v-model="commissionManualValue"
          label="Введите комиссию"
          outline
        />
      </v-flex>
    </v-layout>
    <v-divider />
    <v-layout 
      row 
      wrap
    >
      <v-layout 
        row 
        wrap
      >
        <v-flex xs12>
          <h4 class="title grey--text">
            Итог по каждому типу туриста:
          </h4>
        </v-flex>  
      </v-layout>
      <v-flex xs12>
        <table class="total">
          <thead>
            <th>
              Тип туриста
            </th>
            <th>
              Обычное
            </th>
            <th>
              Single
            </th>
            <th>
              Дополнительное
            </th>
            <th>
              Ребёнок
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-icon 
                    color="grey"
                    v-on="on"
                  >
                    info
                  </v-icon>
                </template>
                <span>
                  Учитывать размещение в отелях по детскому тарифу.
                </span>
              </v-tooltip>
            </th>
          </thead>
          <tbody>
            <tr
              v-for="price in getTourCalc.priceList"
              :key="price.customerId"
              class="text-xs-left subheading"
            >
              <td>
                {{ price.name }}
                <div
                  v-if="price.age"
                  class="grey--text body-1"
                >
                  <div
                    v-if="JSON.parse(price.age).isPens"
                  >
                    Мужчины от {{ JSON.parse(price.age).agePensMale }}
                    <br>
                    Женщины от {{ JSON.parse(price.age).agePensFemale }}
                  </div>
                  <div
                    v-if="!JSON.parse(price.age).isPens"
                  >
                    От {{ JSON.parse(price.age).ageFrom }}
                    до {{ JSON.parse(price.age).ageTo }}
                  </div>
                </div>
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ parseInt(price.commissionStandardPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Комиссия: 
                </span>
                {{ parseInt(price.commissionStandardPrice - price.standardPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ parseInt(price.standardPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Затраты:
                </span> 
                {{ parseInt(price.nettoStandardPrice).toFixed(2) }}
                <v-divider />
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ parseInt(price.standardPrice - price.nettoStandardPrice).toFixed(2) }}
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ parseInt(price.commissionSinglePrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Комиссия: 
                </span>
                {{ parseInt(price.commissionSinglePrice - price.singlePrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ parseInt(price.singlePrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Затраты:
                </span> 
                {{ parseInt(price.nettoSinglePrice).toFixed(2) }}
                <v-divider />
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ parseInt(price.singlePrice - price.nettoSinglePrice).toFixed(2) }}
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ parseInt(price.commissionExtraPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Комиссия: 
                </span>
                {{ parseInt(price.commissionExtraPrice - price.addPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ parseInt(price.addPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Затраты:
                </span> 
                {{ parseInt(price.nettoAddPrice).toFixed(2) }}
                <v-divider />
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ parseInt(price.addPrice - price.nettoAddPrice).toFixed(2) }}
              </td>
              <td>
                <v-checkbox 
                  v-model="price.isChd" 
                  color="#aa282a"
                  name="is-chd"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <v-btn 
          dark
          color="#aa282a"
          @click="calculatePriceForEveryCustomer"
        >
          Рассчитать цены для всех типов туристов
        </v-btn>
        <br>
        <br>
        <v-btn
          dark
          color="#aa282a"
          @click="roundPrices"
        >
          Округлить цены
        </v-btn>
        <br>
        <v-layout
          row
          wrap
        >
          <v-spacer />
          <v-radio-group 
            v-model="roundPricesParameter" 
            row
          >
            <v-radio 
              label="до 100" 
              value="100" 
            />
            <v-radio 
              label="до 1000" 
              value="1000" 
            />
          </v-radio-group>
        </v-layout>
        <v-layout
          row
          wrap
        >
          <v-spacer />
          <v-radio-group 
            v-model="roundPricesMinusValue" 
            row
          >
            <v-radio 
              label="не вычитать" 
              value="0" 
            />
            <v-radio 
              label="минус 10" 
              value="10" 
            />
            <v-radio 
              label="минус 100" 
              value="100" 
            />
          </v-radio-group>
        </v-layout>
      </v-flex>  
    </v-layout>
    <v-layout 
      row 
      wrap
      justify-end
    >
      <v-flex xs2>
        <p>
          Перед сохранением тура, рассчитайте цены для всех типов туристов.
        </p>
      </v-flex>
      <v-flex xs2> 
        <SaveTourForm
          :token="token"
        />
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { setTimeout } from 'timers'
import SaveTourForm from './SaveTourForm'
export default {
  name: 'Summary',
  components: {
    SaveTourForm,
  },
  props: {
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      totalPrice: 0,
      correctedPrice: 0,
      correctionToAll: 0,
      commissionToAll: 0,
      currentCustomerType: 0,
      showStaff: false,
      showDrivers: false,
      showGuides: false,
      showAttendant: false,
      showFreeAdls: false,
      commissionManualMode: false,
      commissionManualValue: 0,
      roundPricesParameter: '100',
      roundPricesMinusValue: '0',
    };
  },
  computed: {
    ...mapGetters([
      'getTour',
      'getCorrectedPrice',
      'getCurrentTourCustomers',
      'getTourCalc',
      'getEditMode',
      'getAverageCommission',
      'getAverageCorrection',
      'getStaffErrors',
      'getFreeAdlErrors',
      'allState',
      'getCanSave',
    ]),
    tourExtra: function() {
      return {
        ...this.getTour, 
        correctedPrice: this.getCorrectedPrice
      }
    },
  },
  watch: {
    // getTour: {
    //   handler(value) {
    //     this.updateTourTotalPrice()
    //     this.updateTourCorrectedPrice()
    //     // this.updateCommissionPriceValues()
    //     this.updateTourCommissionPrice()
    //   },
    //   deep: true,
    // },
    commissionManualValue: {
      handler(value) {
        if (value == NaN || value == '' || value == undefined) {
          value = 0
        }
        if (this.commissionManualMode) {
          this.updateManualCommissionPriceValues(parseFloat(value).toFixed(2))
        }
      }
    },
    commissionManualMode: {
      handler(value) {
        if (value) {
          this.updateCommissiontoAll(0)
          this.updateCommissionPriceValues()
          this.updateTourCommissionPrice()
          this.updateManualCommissionMode(true)
        }
        if (!value) {
          this.commissionToAll = 0
          this.updateCommissiontoAll(0)
          this.updateCommissionPriceValues()
          this.updateTourCommissionPrice()
          this.commissionManualValue = 0
          this.updateManualCommissionMode(false)
        }
      }
    },
    currentCustomerType: {
      handler(value) {
        this.updateCurrentCustomerType(value)
        this.updateTourCorrectedPrice()
        if (!this.commissionManualMode) {
          this.updateCommissionPriceValues()
          this.updateTourCommissionPrice()
        } else {
          this.updateManualCommissionPriceValues(parseFloat(this.commissionManualValue).toFixed(2))
        }
      },
    },
  },
  mounted() {
    if (!this.getEditMode) {
      this.generateTourCalcCustomerTypes(this.getCurrentTourCustomers)
      this.updateTourStaff()
      this.updateTourFreeAdls()
      this.updateTourTotalPrice()
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      if (!this.commissionManualMode) {
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      }
      if (this.commissionManualMode) {
        this.updateCommissiontoAll(0)
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      }
      this.calculatePriceForEveryCustomer()
    }
    this.commissionManualMode = this.getTour.calc.commissionManualMode
    this.commissionManualValue = this.getTour.calc.commissionManualValue
  },
  methods: {
    ...mapActions([
      'updateTransportPrice',
      'updateTourTotalPrice',  
      'updateTourCorrectedPrice',
      'updateCorrectionToAll',
      'updateCorrectedPriceValues',
      'updateCurrentCustomerType',
      'generateTourCalcCustomerTypes',
      'updateCommissiontoAll',
      'updateCommissionPriceValues',
      'updateTourCommissionPrice',
      'updateTourStaff',
      'updateTourFreeAdls',
      'updateManualCommissionPriceValues',
      'updateManualCommissionMode',
      'updateCanSave',
      'updateTourTransport',
      'updateTourMuseum',
      'updateTourHotel',
      'updateTourGuide',
      'updateTourAttendant',
      'updateTourStaff',
      'updateTourFreeAdls',
      'updateRoundPrices',
    ]),
    saveTour() {
      console.log(this.getTour)
    },
    inputCorrection() {
      this.updateCorrectionToAll(this.correctionToAll)
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      if (!this.commissionManualMode) {
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      } else {
        this.updateManualCommissionPriceValues(parseFloat(this.commissionManualValue).toFixed(2))
      }
    },
    inputCommission() {
      this.updateCommissiontoAll(this.commissionToAll)
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      if (!this.commissionManualMode) {
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      } else {
        this.updateManualCommissionPriceValues(parseFloat(this.commissionManualValue).toFixed(2))
      }
    },
    correctPrice() {
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      if (!this.commissionManualMode) {
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      } else {
        this.updateManualCommissionPriceValues(parseFloat(this.commissionManualValue).toFixed(2))
      }
    },
    commissPrice() {
      this.updateTourCorrectedPrice()
      if (!this.commissionManualMode) {
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      } else {
        this.updateManualCommissionPriceValues(parseFloat(this.commissionManualValue).toFixed(2))
      }
  },
    customerName(event) {
      const data = JSON.parse(event.obj.extra)
      const currentPrice = data.priceList.find(price => price.customerId == this.currentCustomerType)
      if (currentPrice) {
        return currentPrice.customerName
      }
      else {
        const defaultPrice = data.priceList.find(price => price.customerId == 1) // Взрослый
        return defaultPrice.customerName
      }
    },
    eventPrice(event) {
      const data = JSON.parse(event.obj.extra)
      const currentPrice = data.priceList.find(price => price.customerId == this.currentCustomerType)
      if (currentPrice) {
        return currentPrice.price
      }
      else {
        return data.priceList.find(price => price.customerId == 1).price // Цена за взрослого
      }
    },
    calculatePriceForEveryCustomer() {
      let prevCustomer = this.currentCustomerType
      this.getCurrentTourCustomers.forEach((customer) => {
        setTimeout(() => { 
          this.currentCustomerType = customer.id
          this.correctPrice()
        }, 300)
      })
      setTimeout(() => {
        this.currentCustomerType = prevCustomer
        this.updateCurrentCustomerType(this.currentCustomerType)
        this.correctPrice()
      }, 2000)
      this.updateCanSave(true)
    },
    customerChanged() {
      this.updateCurrentCustomerType(this.currentCustomerType)
      this.updateCorrectedPriceValues()
    },
    getHotelPrice(hotel) {
      let customer = this.getTour.calc.priceList.find((item) => {
        return item.id == this.currentCustomerType
      })
      if (customer && customer.isChd) {
        return JSON.parse(hotel.obj.extra).priceList.chd.std * hotel.obj.day
      }
      else {
        return JSON.parse(hotel.obj.extra).priceList.adl.std * hotel.obj.day
      }
    },
    reCalcTour() {
      this.updateTourTransport()
      this.updateTourMuseum()
      this.updateTourHotel()
      this.updateTourGuide()
      this.updateTourAttendant()
      this.updateTourStaff()
      this.updateTourFreeAdls()
      this.generateTourCalcCustomerTypes(this.getCurrentTourCustomers)
      this.updateTourStaff()
      this.updateTourFreeAdls()
      this.updateTourTotalPrice()
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      if (!this.commissionManualMode) {
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      }
      if (this.commissionManualMode) {
        this.updateCommissiontoAll(0)
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      }
      this.calculatePriceForEveryCustomer()
    },
    roundPrices() {
      this.updateRoundPrices({
        parameter: this.roundPricesParameter, 
        minusValue: this.roundPricesMinusValue
      })
    },
  },
};
</script>

<style lang="scss" scoped>
.summary,
.total {
  margin: 0 auto;
  td,
  th {
    border: 1px solid #e8e8e8;
    padding: 16px;
    font-size: 24px;
    font-weight: 250;
  }
  td {
    text-align: left
  }
}
</style>
