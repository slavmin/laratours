<template>
  <v-btn 
    color="green"
    dark
    @click="getWord(profiles)"
  >
    Ваучер.docx
  </v-btn>
</template>
<script>
import { mapGetters } from 'vuex'
import { 
  AlignmentType,
  Document, 
  Media, 
  Header,
  HeadingLevel,
  Paragraph, 
  Packer, 
  TextRun, 
  TableOfContents, 
  Table,
  TableRow,
  TableCell,
  TableAnchorType,
  RelativeHorizontalPosition,
  RelativeVerticalPosition,
  TableLayoutType,
  StyleLevel, 
} from "docx"
import { saveAs } from 'file-saver'
import moment from 'moment'
// import fs from 'fs'
export default {
  name: 'VaucherWord',
  props: {
    profiles: {
      type: Object,
      default: () => {
        return {}
      } 
    },
    tour: {
      type: Object,
      default: () => {
        return {}
      } 
    },
    order: {
      type: Object,
      default: () => {
        return {}
      } 
    }
  },
  data() {
    return {
      
    }
  },
  computed: {
    ...mapGetters([
      'getOrderContacts',
    ])
  },
  mounted() {
    console.log(this.profiles, JSON.parse(this.tour.extra), this.order)
  },
  methods: {
    getWord(order) {
      const doc = new Document();
      doc.addSection({
        headers: {
          default: new Header({
            children: [
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
            ]
          }),
        },
        children: [
          new Paragraph({
            text: "ВАУЧЕР No 18/07/19",
            alignment: AlignmentType.CENTER,
            heading: HeadingLevel.HEADING_1,
          }),
        ],
        children: this.getData(),
      })
      Packer.toBlob(doc).then((blob) => {
        saveAs(blob, "word.docx");
      });
    },
    getData() {
      let result = []
      // vaucher number
      result.push(
        new Paragraph({
        text: "ВАУЧЕР No 18/07/19",
        alignment: AlignmentType.CENTER,
        heading: HeadingLevel.HEADING_1,
      }))
      // tourist info
      result.push(...this.touristsInfo())
      // tour info
      result.push(...this.tourInfo())
      return result
    },
    touristsInfo() {
      let result = []
      let profilesCount = 0
      result.push(new Paragraph({
        text: `Туристы`,
        alignment: AlignmentType.CENTER,
        heading: HeadingLevel.HEADING_2,
      }))
      for (let key in this.profiles) {
        const profile = this.profiles[key]
        profilesCount += 1
        result.push(
          new Paragraph({
            children: [
              new TextRun({
                text: `Турист ${parseInt(key) + 1}: `,
                bold: true,
                underline: {},
              })
            ]
          }),
          new Paragraph({
            text: `ФИО туриста: ${profile.first_name} ${profile.last_name}`,
          }),
          new Paragraph({
            text: `Дата рождения: ${profile.dob}`,
          }),
          new Paragraph({
            text: `Паспорт: ${profile.passport}`,
          }),
        )
      }
      result.push(
        new Paragraph({
          text: `Контакты туристов: ${this.getOrderContacts.email} ${this.getOrderContacts.phone} ${this.getOrderContacts.name}`,
        })
      )
      result.push(
        new Paragraph({
          text: `Количество человек: ${profilesCount}`,
          border: {
            bottom: {
              color: "auto",
              space: 1,
              value: "single",
              size: 6,
            },
          },
        })
      )
      return result
    },
    tourInfo() {
      const tour = JSON.parse(this.tour.extra)
      let result = []
      moment.locale('ru')
      const dateStart = moment(tour.options.dateStart).format('LL')
      result.push(new Paragraph({
        text: `Тур: "${tour.options.name}"`,
        alignment: AlignmentType.CENTER,
        heading: HeadingLevel.HEADING_2,
      }))
      result.push(
        new Paragraph({
          children: [
            new TextRun({
              text: `Дата начала: ${dateStart}. `,
            }),
            new TextRun({
              text: `Количество дней: ${tour.options.days}.`,
            }),
          ],
          border: {
            bottom: {
              color: "auto",
              space: 1,
              value: "single",
              size: 6,
            },
          },
        }),
      )
      result.push(new Paragraph({
        text: `Проживание"`,
        alignment: AlignmentType.CENTER,
        heading: HeadingLevel.HEADING_3,
      }))
      tour.hotel.forEach((hotel) => {
        result.push(
          new Paragraph({
          children: [
            new TextRun({
              text: `Гостиница: ${hotel.hotel.name}. `,
            }),
            new TextRun({
              text: `Номер: ${hotel.obj.name}. `,
            }),
            new TextRun({
              text: `Количество номеров: 1.`,
            }),
          ],
          border: {
            bottom: {
              color: "auto",
              space: 1,
              value: "single",
              size: 6,
            },
          },
        }))
      })
      result.push(new Paragraph({
        text: `Экскурсии"`,
        alignment: AlignmentType.CENTER,
        heading: HeadingLevel.HEADING_3,
      }))
      tour.museum.forEach((museum) => {
        result.push(
          new Paragraph({
          children: [
            new TextRun({
              text: `${museum.museum.name}, `,
            }),
            new TextRun({
              text: `${museum.obj.name}.`,
            }),
          ],
          border: {
            bottom: {
              color: "auto",
              space: 1,
              value: "single",
              size: 6,
            },
          },
        }))
      })
      result.push(new Paragraph({
        text: `Питание"`,
        alignment: AlignmentType.CENTER,
        heading: HeadingLevel.HEADING_3,
      }))
      tour.meal.forEach((meal) => {
        result.push(
          new Paragraph({
          children: [
            new TextRun({
              text: `День: ${meal.obj.day}: ${meal.meal.name}, `,
            }),
            new TextRun({
              text: `${meal.obj.name}, ${meal.obj.description}.`,
            }),
          ],
          border: {
            bottom: {
              color: "auto",
              space: 1,
              value: "single",
              size: 6,
            },
          },
        }))
      })
      result.push(
        new Paragraph({
          text: `Полная стоимость: ${this.order.total_price}.`,
        })
      )
      result.push(
          new Paragraph({
            text: `Ваш менеджер: Иванов И.И. Телефон: 8-911-222-12-32`,
        })
      )
      console.log(result)
      return result
    }
  }
}
</script>