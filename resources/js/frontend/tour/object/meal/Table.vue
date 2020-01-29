<template>
  <v-layout column>
    <v-layout
      row
      wrap
      class="white--text"
    >
      <v-flex
        v-for="meal in items.data"
        :key="meal.id"
        mb-5
        xs12
        md12
        lg6
        xl4
      >
        <v-card>
          <v-card-title
            class="white--text"
            style="background-color: #66a5ae;"
          >
            <div>
              <h3 class="display-1">
                {{ meal.name }}
              </h3>
              <div class="text-xs-left subheading mb-3">
                {{ getCityName(meal.city_id) }}
                {{ JSON.parse(meal.extra).address }}
              </div>
            </div>
            <Edit
              :meal="meal"
              :token="token"
            />
            <form
              :action="'/operator/meal/' + meal.id"
              method="post"
            >
              <input
                type="hidden"
                name="_method"
                value="DELETE"
              >
              <input
                type="hidden"
                name="_token"
                :value="token"
              >
              <v-btn
                small
                fab
                :title="`Удалить '` + meal.name + `'`"
                color="red"
                dark
                type="submit"
              >
                <i class="material-icons">
                  delete
                </i>
              </v-btn>
            </form>
          </v-card-title>
          <v-card-text style="color: #979694;">
            <v-layout>
              <div class="mr-3">
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  web
                </i>
                <a
                  :href="JSON.parse(meal.extra).contacts.site"
                  target="_blank"
                >
                  {{ JSON.parse(meal.extra).contacts.site }}
                </a>
              </div>
              <div class="mr-3">
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  email
                </i>
                <a :href="'mailto:' + JSON.parse(meal.extra).contacts.email">
                  {{ JSON.parse(meal.extra).contacts.email }}
                </a>
              </div>
              <div>
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  phone
                </i>
                {{ JSON.parse(meal.extra).contacts.phone }}
              </div>
            </v-layout>
            <v-layout
              row
              wrap
              mb-2
            >
              <div class="mr-3">
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  person
                </i>
                {{ JSON.parse(meal.extra).staff.name }}
              </div>
              <div>
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  phone
                </i>
                {{ JSON.parse(meal.extra).staff.phone }}
              </div>
            </v-layout>
            <div class="heading text-xs-left mb-3">
              {{ JSON.parse(meal.extra).about }}
            </div>
            <v-data-table
              :headers="headers"
              :items="meal.objectables"
              class="elevation-1"
              rows-per-page-text="На странице:"
            >
              <template v-slot:items="props">
                <td class="text-xs-left">
                  {{ props.item.name }}
                </td>
                <td class="text-xs-center">
                  {{ props.item.price }}
                </td>
                <td class="text-xs-center">
                  {{ props.item.description }}
                </td>
                <td>
                  <v-layout
                    row
                    wrap
                    justify-end
                  >
                    <EditObjectables
                      :meal="meal"
                      :event="props.item"
                      :token="token"
                    />
                    <form
                      :action="'/operator/attribute/' + props.item.id"
                      method="POST"
                    >
                      <input
                        type="hidden"
                        name="_method"
                        value="DELETE"
                      >
                      <input
                        type="hidden"
                        name="_token"
                        :value="token"
                      >
                      <input
                        type="hidden"
                        name="parent_model_id"
                        :value="meal.id"
                      >
                      <input
                        type="hidden"
                        name="parent_model_alias"
                        value="meal"
                      >
                      <v-btn
                        fab
                        small
                        outline
                        color="red"
                        type="submit"
                      >
                        <i class="material-icons">
                          delete
                        </i>
                      </v-btn>
                    </form>
                  </v-layout>
                </td>
              </template>
            </v-data-table>
          </v-card-text>
          <v-card-actions>
            <AddObjectables
              :meal="meal"
              :token="token"
            />
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
import Edit from './Edit'
import AddObjectables from './AddObjectables'
import EditObjectables from './EditObjectables'
export default {
  name: 'ObjectHotelTable',
  components: {
    Edit,
    AddObjectables,
    EditObjectables,
  },
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      },
    },
    token: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      headers: [
        {
          text: 'Название',
          align: 'left',
          value: 'name',
        },
        {
          text: 'Цена',
          align: 'center',
          value: 'price',
        },
        {
          text: 'Описание',
          align: 'center',
          value: 'description',
        },
        {
          text: 'Действия',
          align: 'center',
          value: 'actions',
        },
      ],
    }
  },
  computed: {
    ...mapGetters(['allCities']),
  },
  mounted() {
    // this.fetchMeal()
    // this.fetchCities()
  },
  methods: {
    ...mapActions(['fetchCities']),
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
  },
}
</script>
