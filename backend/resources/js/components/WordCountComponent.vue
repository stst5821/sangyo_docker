<template>
  <input
    v-model="myText"
    id="{data.id}"
    name="body1"
    class="form-control {{ $errors->has('{{data.id}}}') ? 'is-invalid' : '' }}"
    rows="4"
    type="text"
  />
</template>

<script>
var app = new Vue({
  el: "#app1",
  data: {
    myText: "",
  },
  computed: {
    remaining: function () {
      return 15 - this.myText.length;
    },
    computedColor: function () {
      col = "#33a";
      if (this.remaining < 5) {
        col = "#3a3";
      }
      if (this.remaining < 1) {
        col = "#a33";
      }
      return col;
    },
  },
});
</script>
