<template>
  <v-dialog
    v-model="showResetPassword"
    persistent
    max-width="500px"
  >
    <v-card>
      <v-card-title>
        <span class="headline">Reset password</span>
      </v-card-title>
      <v-card-text>
        <v-form
          ref="resetPasswordForm"
          v-model="valid"
        >
          <v-text-field
            v-model="internalEmail"
            label="Email"
            :rules="emailRules"
            required
          />
          <v-text-field
            v-model="password"
            name="password"
            label="Password"
            :rules="passwordRules"
            hint="At least 6 characters"
            min="6"
            type="password"
            required
          />
          <v-text-field
            v-model="passwordConfirmation"
            name="passwordConfirmation"
            label="Password confirmation"
            :rules="passwordRules"
            hint="At least 6 characters"
            min="6"
            type="password"
            required
          />
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn
          color="blue darken-1"
          flat
          @click.native="showResetPassword = false"
        >
          Close
        </v-btn>
        <v-btn
          :loading="loading"
          flat
          :color="done ? 'green' : 'blue'"
          @click.native="reset"
        >
          <v-icon v-if="done">
            done
          </v-icon>
          &nbsp;
          <template v-if="!done">
            Reset
          </template>
          <template v-else>
            Done
          </template>
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>


<script>
import * as actions from '../store/action-types'
import sleep from '../utils/sleep'
import withSnackbar from './mixins/withSnackbar'
export default {
  mixins: [withSnackbar],
  props: {
    action: {
      type: String,
      default: null,
    },
    token: {
      type: String,
      default: null,
    },
    email: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      internalAction: this.action,
      internalEmail: this.email,
      loading: false,
      done: false,
      emailRules: [
        v => !!v || 'El email és obligatori',
        v =>
          /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "S'ha d'indicar un email vàlid",
      ],
      password: '',
      passwordConfirmation: '',
      passwordRules: [
        v => !!v || 'La paraula de pas és obligatòria',
        v =>
          v.length >= 6 ||
          'La paraula de pas ha de tenir com a mínim 6 caràcters',
      ],
      valid: false,
    }
  },
  computed: {
    showResetPassword: {
      get() {
        return this.internalAction && this.internalAction === 'reset_password'
      },
      set(value) {
        if (value) this.internalAction = 'reset_password'
        else this.internalAction = null
      },
    },
  },
  methods: {
    reset() {
      if (this.$refs.resetPasswordForm.validate()) {
        const user = {
          email: this.internalEmail,
          password: this.password,
          password_confirmation: this.passwordConfirmation,
          token: this.token,
        }
        this.loading = true
        this.$store
          .dispatch(actions.RESET_PASSWORD, user)
          .then(response => {
            this.loading = false
            this.done = true
            sleep(4000).then(() => {
              this.showResetPassword = false
              window.location = '/home'
            })
          })
          .catch(error => {
            if (error.response && error.response.status === 422) {
              this.showError({
                message: 'Invalid data',
              })
            } else {
              this.showError(error)
            }
            this.errors = error.response.data.errors
          })
          .then(() => {
            this.loading = false
          })
      }
    },
  },
}
</script>
