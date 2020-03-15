<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Допы
      </h3>
    </v-col>
    <v-col cols="12">
      <v-simple-table
        v-if="items.length > 0"
        dense
      >
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                Название
              </th>
              <th class="text-left">
                Цена
              </th>
              <th class="text-right">
                Действия
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in items"
              :key="item.id"
            >
              <td>{{ item.name }}</td>
              <td>{{ item.value }}</td>
              <td class="text-right">
                <v-btn
                  small
                  text
                  color="yellow"
                  @click="editExtra(item)"
                >
                  <v-icon>edit</v-icon>
                </v-btn>
                <v-btn
                  small
                  text
                  color="red"
                  @click="deleteExtra(item.id)"
                >
                  <v-icon>delete</v-icon>
                </v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-col>
    <v-col cols="12">
      <v-form
        ref="form"
        v-model="valid"
      >
        <v-row>
          <v-col
            cols="12"
            md="5"
          >
            <v-text-field
              v-model="name"
              color="#aa282a"
              label="Название"
              :rules="[v => !!v || 'Введите название']"
              required
            />
          </v-col>
          <v-col
            cols="12"
            md="5"
          >
            <v-text-field
              v-model.number="value"
              color="#aa282a"
              label="Цена"
              :rules="[v => !!v || 'Введите цену']"
              required
            />
          </v-col>
          <v-col>
            <v-btn
              dark
              small
              color="#aa282a"
              @click="addOrUpdate"
            >
              <v-icon>add</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: 'TourExtras',
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      id: null,
      name: '',
      value: null,
      items: [],
      valid: false,
    }
  },
  mounted() {
    this.fetchTourExtra()
  },
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true
      }
    },
    resetValidation() {
      this.$refs.form.resetValidation()
    },
    fetchTourExtra() {
      axios
        .get('/api/get-detailed-tour-extra', {
          params: {
            tour_id: this.tourId,
          },
        })
        .then(r => (this.items = r.data))
    },
    addOrUpdate() {
      this.validate()
      if (this.valid) {
        axios
          .post('/api/add-or-update-detailed-tour-extra', {
            tour_id: this.tourId,
            extra_id: this.id,
            name: this.name,
            value: this.value,
          })
          .then(r => {
            console.log(r)
            this.name = ''
            this.value = null
            this.resetValidation()
          })
          .then(r => this.fetchTourExtra())
      }
    },
    editExtra(item) {
      this.id = item.id
      this.name = item.name
      this.value = item.value
    },
    deleteExtra(id) {
      axios
        .post('/api/delete-detailed-tour-extra', {
          extra_id: id,
        })
        .then(r => this.fetchTourExtra())
    },
  },
}
</script>