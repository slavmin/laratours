<template>
  <v-btn 
    color="green"
    dark
    @click="getWord(profile)"
  >
    Ваучер.docx
  </v-btn>
</template>
<script>
import { 
  Document, 
  Media, 
  Headers,
  Paragraph, 
  Packer, 
  TextRun, 
  TableOfContents, 
  StyleLevel, 
  HeadingLevel 
  } from "docx"
import { saveAs } from 'file-saver'
// import fs from 'graceful-fs'
export default {
  name: 'VaucherWord',
  props: {
    profile: {
      type: Object,
      default: () => {
        return {}
      } 
    },
  },
  data() {
    return {
      
    }
  },
  mounted() {
    console.log(this.profile)
  },
  methods: {
    getWord(order) {
      const doc = new Document();
      // const logo = Media.addImage(doc, fs.readFile('/public/img/frontend/alphavit-logo.png'))
      doc.addSection({
        // headers: {
        //   default: new Header({
        //     children: [
        //       new Paragraph({
        //         children: [logo],
        //       })
        //     ]
        //   }),
        // },
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
          // new Paragraph(`Турист: ${order.profiles[0].content[0].first_name} ${order.profiles[0].content[0].last_name} ${order.profiles[0].content[0].dob}`),
      ],
      })
      Packer.toBlob(doc).then((blob) => {
        saveAs(blob, "word.docx");
      });
    },
  }
}
</script>