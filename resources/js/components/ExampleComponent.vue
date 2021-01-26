<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ data.header }}</div>

          <div class="card-body">{{ data.body }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    data: {},
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
