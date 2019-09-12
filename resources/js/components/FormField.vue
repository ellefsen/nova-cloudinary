<template>
  <default-field
    :field="field"
    :errors="errors">
    <template slot="field">
      <div
        v-if="value"
        style="max-width:400px;">
        <div
          v-if="field.type && field.type === 'video'"
          class="card relative card relative border border-lg border-50 overflow-hidden px-0 py-0 mb-4">
          <video
            class="block w-full"
            controls="controls"
            :poster="videoThumbnail">
            <source
              :src="videoPath + videoFilename + '.webm'"
              type="video/webm">
            <source
              :src="videoPath + videoFilename + '.mp4'"
              type="video/mp4">
            <source
              :src="videoPath + videoFilename + '.ogv'"
              type="video/ogg">
          </video>
        </div>
        <div
          v-else
          class="card relative card relative border border-lg border-50 overflow-hidden px-0 py-0 mb-4">
          <img
            :src="imageFullPath"
            class="block w-full"
            alt="">
        </div>

        <p class="my-4 text-80 text-xs">
          {{ value }}
        </p>
      </div>
      <input
        :id="field.name"
        type="hidden"
        class="hidden"
        :class="errorClasses"
        :placeholder="field.name"
        v-model="value"
      >
      <button
        class="btn btn-default btn-primary inline-flex items-center relative"
        @click.prevent="openWidget">
        Choose File
      </button>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova"

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    computed: {
      imagePath () {
        return "https://res.cloudinary.com/aeonas/image/upload/"
      },
      imageFullPath () {
        return this.value ? `${this.imagePath}/${this.transformations}/${this.value}` : ""
      },
      videoPath () {
        return "https://res.cloudinary.com/aeonas/video/upload/"
      },
      videoFullPath () {
        return this.value ? `https://res.cloudinary.com/aeonas/video/upload/${this.value}` : ""
      },
      videoFilename () {
        return this.value.split(".").slice(0, -1).join(".")
      },
      videoThumbnail () {
        return this.value ? `https://res.cloudinary.com/aeonas/video/upload/${this.transformations}/${this.videoFilename}.jpg` : ""
      },
      transformations () {
        let trans = [
          ["q", 90]
        ]

        let imported = Object.keys(this.field.transformations || []).map(key => {
          return [key, this.field.transformations[key]]
        })

        return [...trans, ...imported].map(prop => prop.join("_")).join(",")
      }
    },

    data () {
      return {
        widget: null,
        value: null,
        baseUrl: ""
      }
    },

    mounted () {
      let formats = null
      switch(this.field.type) {
        case "video":
          formats = ["mp4"]
          break
        default:
          formats = ["png", "jpeg"]
      }

      console.log(this.transformations)
      console.log(this.field)

      this.widget = window.cloudinary.createUploadWidget({
        cloudName: "aeonas",
        clientAllowedFormats: formats,
        maxFiles: 1,
        uploadPreset: "mrallr46"}, (error, result) => {
          if (!error && result && result.event === "success") {
            console.log("Done! Here is the image info: ", result.info)
            this.handleChange(result.info.path)
          }
        }
      )
    },

    methods: {
      /*
        * Set the initial, internal value for the field.
        */
      setInitialValue() {
        this.value = this.field.value || ""
      },

      /**
       * Fill the given FormData object with the field's internal value.
       */
      fill(formData) {
        formData.append(this.field.attribute, this.value || "")
      },

      /**
       * Update the field's internal value.
       */
      handleChange(value) {
        this.value = value
      },

      openWidget () {
        this.widget.open()
      }
    },
}
</script>
