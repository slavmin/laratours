<template>
  <table>
    <thead>
      <th>
        №
      </th>
      <th>
        Туристов
      </th>
      <th>
        Агент
      </th>
      <th>
        Статус агентства
      </th>
      <th>
        Статус оператора
      </th>
      <th>
        Документы
      </th>
      <th>
        Действия
      </th>
    </thead>
    <tbody>
      <tr
        v-for="order in tour.orders"
        :key="order.id"
      >
        <td>
          {{ order.id }}
        </td>
        <td>
          Туристов: {{ touristsCount(order.profiles[0].content) }}
          <br>
          <i
            v-for="n in touristsCount(order.profiles[0].content)"
            :key="n" 
            class="material-icons body-2"
          >
            accessibility_new
          </i>
          <br>
          <Details 
            :profiles="order.profiles"
            :order-id="order.id"
          />
          <HasNewMessage 
            :chat="JSON.parse(order.profiles[0].content[0].chat)"
            recipient="Оператор"
          />
        </td>
        <td>
          {{ agencies[order.team_id] }}
        </td>
        <td>
          {{ order.profiles[0].content[0].orderStatus }}
        </td>
        <td>
          <span 
            class="status"
            :class="statuses[order.status]"
          >
            {{ statusesTranslated[order.status] }}
          </span>
        </td>
        <td>
          <v-btn 
            color="green"
            dark
            @click="getPdf(order)"
          >
            pdf
          </v-btn>
          <v-btn 
            color="green"
            dark
            @click="getWord(order)"
          >
            word
          </v-btn>
        </td>
        <td>
          <v-layout 
            row 
            wrap
          >
            <v-btn
              :href="'/operator/order/' + order.id + '/edit'"
              color="green"
              dark
              small
              fab
              flat
              outline
            >
              <i class="material-icons">
                edit
              </i>
            </v-btn>
            <form 
              :action="'/operator/order/' + order.id"
              method="POST"
            >
              <input 
                id="_method" 
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
      </tr>
    </tbody>
  </table>
</template>
<script>
import pdfMake from "pdfmake/build/pdfmake"
import pdfFonts from "pdfmake/build/vfs_fonts"
pdfMake.vfs = pdfFonts.pdfMake.vfs
import { Document, Paragraph, Packer, TextRun, TableOfContents, StyleLevel, HeadingLevel } from "docx"
import { saveAs } from 'file-saver'
import Details from './Details'
import HasNewMessage from '../includes/HasNewMessage'
export default {
  name: 'Profiles',
  components: {
    Details,
    HasNewMessage,
  },
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
    token: {
      type: String,
      default: ''
    },
    agencies: {
      type: Object,
      default: () => {
        return {}
      }
    },
    statuses: {
      type: Array,
      default: () => {
        return []
      }
    },
    tourNames: {
      type: Object,
      default: () => {
        return []
      }
    },
  },
  data() {
    return {
      statusesTranslated: [
        'Не подтвержден', 
        'Подтвержден', 
        'Оплачен',
        'Отменен',
        'Отклонен',
        'Завершен',
      ]
    }
  },
  mounted() {
  },
  methods: {
    touristsCount(content) {
      let count = 0
      for (let key in content) {
        count += 1
      }
      return count
    },
    getPdf(order) {
      console.log(order)
      let dd = {
        content: [
          "ООО «Туроператор Алфавит» www.alfavit-travel.ru",
          "ИНН 7840055086 / КПП 784001001",
          "191014, г. Санкт-Петербург, Артиллерийская улица, 1, лит. А, оф. 132",
          '______________________',
          order.profiles[0].content[0].first_name,
          order.profiles[0].content[0].last_name,
          order.profiles[0].content[0].dob,
          order.profiles[0].content[0].email,
          order.profiles[0].content[0].passport,
        ]   
      }
      pdfMake.createPdf(dd).open();
    },
    getWord(order) {
      const doc = new Document();
      doc.addSection({
        children: [
          // new Paragraph({
          //   text: "Header #1",
          //   heading: HeadingLevel.HEADING_1,
          // }),
          new Paragraph("ООО «Туроператор Алфавит» www.alfavit-travel.ru"),
          new Paragraph("ИНН 7840055086 / КПП 784001001"),
          new Paragraph("191014, г. Санкт-Петербург, Артиллерийская улица, 1, лит. А, оф. 132"),
          new Paragraph({
            border: {
              bottom: {
                color: "auto",
                space: 1,
                value: "single",
                size: 6,
              },
            },
            text: "Тел.: +7 (812) 579-65-56 info@alfavit-travel.ru",
          }),
          new Paragraph({
            text: "ВАУЧЕР No 18/07/19",
            // pageBreakBefore: true,
          }),
          new Paragraph(`Турист: ${order.profiles[0].content[0].first_name} ${order.profiles[0].content[0].last_name} ${order.profiles[0].content[0].dob}`),
      ],
      })
      Packer.toBlob(doc).then((blob) => {
        saveAs(blob, "word.docx");
      });
    },
  },
}
</script>
<style lang="scss" scoped>
table {
  td,
  th {
    font-size: 16px;
    padding: 12px;
  }
  th {
    border-bottom: 2px solid #cac8c9;
    color: #868080;
    padding-top: 24px;
    padding-bottom: 36px;
    font-size: 16px;
    font-weight: normal;
  }
}
span {
  &.status {
    display: block;
    padding: 6px;
    border-radius: 6px;
    color: white;
    font-size: 12px;
    text-align: center;
  }
  &.pending {
    background-color: #FDD835;
  }
  &.confirmed {
    background-color: rgb(40, 43, 214);
  }
  &.paid {
    background-color: rgb(17, 150, 0);
  }
  &.cancelled {
    background-color: rgb(180, 2, 2);
  }
  &.declined {
    background-color: rgb(255, 0, 0);
  }
  &.completed {
    background-color: rgb(126, 255, 143);
  }
}
</style>