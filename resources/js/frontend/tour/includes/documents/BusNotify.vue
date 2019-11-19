<template>
  <v-btn 
    color="green"
    dark
    small
    @click="getWord"
  >
    Уведомление ГИБДД.docx
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
moment.locale('ru')
export default {
  name: 'BusNotify',
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  methods: {
    getWord() {
      const doc = new Document();
      doc.addSection({
        children: [
          new Paragraph({
            text: "УВЕДОМЛЕНИЕ ОБ ОРГАНИЗОВАННОЙ ПЕРЕВОЗКЕ ДЕТЕЙ АВТОБУСОМ",
            alignment: AlignmentType.CENTER,
            heading: HeadingLevel.HEADING_1,
          }),
        ],
        children: this.getData(),
      })
      Packer.toBlob(doc).then((blob) => {
        saveAs(blob, "notify.docx");
      });
    },
    getData() {
      let result = []
      const tour = JSON.parse(this.tour.extra)
      console.log(tour)
      result.push(
        new Paragraph({
        text: "УВЕДОМЛЕНИЕ ОБ ОРГАНИЗОВАННОЙ ПЕРЕВОЗКЕ ДЕТЕЙ АВТОБУСОМ",
        alignment: AlignmentType.CENTER,
        heading: HeadingLevel.HEADING_3,
      }))
      // Date start
      result.push(new Paragraph({
        children: [
          new TextRun({
            text: 'Дата перевозки: ',
            bold: true,
          }),
          new TextRun({
            text: moment(tour.options.dateStart).format('LL')
          })
        ]
      }))
      result.push(new Paragraph({}))
      // Bus info
      result.push(new Paragraph({
        children: [
          new TextRun({
            text: 'Марка и регистрационный знак автобуса: ',
            bold: true,
          })
        ]
      }))
      tour.transport.forEach((transport, number) => {
        const docs = JSON.parse(transport.obj.extra).busDocs
        const drivers = JSON.parse(transport.obj.extra).drivers
        console.log(docs, drivers)
        // Bus docs
        let textArray = [
          new TextRun({
            text: number,
            bold: true,
          }),
          new TextRun({
            text: `Марка, модель: ${transport.obj.name}. `
          }),
          new TextRun({
            text: `Гос. номер: ${docs.regNumber}. `,
          }),
          new TextRun({
            text: `Описание автобуса: ${transport.obj.description}. `,
          }),
          new TextRun({
            text: `Диагностическая карта: ${docs.diagCard}. `,
          }),
        ]
        if (docs.glonass) {
          textArray.push(new TextRun({
            text: 'Глонасс. '
          }))
        }
        if (docs.eraGlonass) {
          textArray.push(new TextRun({
            text: 'ЭРА-Глонасс. '
          }))
        }
        result.push(new Paragraph({
          children: textArray,
        }))
        result.push(new Paragraph({}))
        // Drivers info
        result.push(new Paragraph({
        children: [
            new TextRun({
              text: 'Водители: ',
              bold: true,
            })
          ]
        }))
        drivers.forEach((driver, driverNumber) => {
          let textArray = []
          console.log(driverNumber)
          textArray.push(new TextRun({
            text: driverNumber,
            bold: true
          }))
          textArray.push(new TextRun({
            text: `${driver.name}, водительское удостоверение: ${driver.license}, стаж ${driver.exp}. `
          }))
          result.push(new Paragraph({
            children: textArray,
          }))
        })
      })
      return result
    },
  }
}
</script>