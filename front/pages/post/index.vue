<template>
  <div>
    <div class="container">
      <form class="form" @submit.prevent="onSubmit">
        <div class="form-links">
          <nuxt-link to="/tl" class="link">キャンセル</nuxt-link>
          <Button type="submit" size="small" :disabled="!canPost()"
            >投稿</Button
          >
        </div>
        <p v-if="error" class="error-msg">投稿に失敗しました</p>
        <div v-if="prefectures && budgets && targets">
          <div class="form-item">
            <TextBox
              name="title"
              placeholder="タイトル"
              :validator="validateTitle"
            />
          </div>
          <div class="form-item">
            <SelectBox
              name="prefecture"
              :options="prefectureOptions"
              :validator="validatePrefecture"
            />
          </div>
          <div class="form-item">
            <SelectBox
              name="budget"
              :options="budgetOptions"
              :validator="validateBudget"
            />
          </div>
          <div class="form-radio">
            <RadioButton
              v-for="target in targets"
              :id="`target-${target.id}`"
              :key="target.id"
              name="target"
              :value="String(target.id)"
              :text="target.name"
              :checked="target.id === 1"
            />
          </div>
          <div class="flow-text">デートの流れ</div>
          <div class="flow-chart">
            <FlowChart ref="flowChart" />
          </div>
        </div>
      </form>
    </div>
    <Loading v-if="loading" />
  </div>
</template>

<script>
import TextBox from '~/components/form/textbox.vue'
import SelectBox from '~/components/form/select.vue'
import RadioButton from '~/components/form/radio.vue'
import Button from '~/components/button/index.vue'
import FlowChart from '~/components/flow-chart/builder.vue'
import Loading from '~/components/loading/index.vue'

export default {
  components: {
    SelectBox,
    RadioButton,
    Button,
    TextBox,
    FlowChart,
    Loading,
  },
  data() {
    return {
      prefectures: null,
      budgets: null,
      targets: null,
      loading: false,
      error: false,
      prefectureOptions: [
        {
          value: '0',
          text: '地域を選択してください',
          selected: true,
        },
      ],
      budgetOptions: [
        {
          value: '0',
          text: '予算を選択してください',
          selected: true,
        },
      ],
      validate: {
        title: false,
        prefecture: false,
        budget: false,
      },
    }
  },
  mounted() {
    this.loading = true
    Promise.all([
      this.fetchPrefectures(),
      this.fetchBudgets(),
      this.fetchTargets(),
    ]).finally(() => {
      this.loading = false
    })
  },
  methods: {
    fetchPrefectures() {
      return this.$fetchPrefectures().then((prefectures) => {
        this.prefectures = prefectures
        this.addPrefectureOptions(prefectures)
      })
    },
    fetchBudgets() {
      return this.$fetchBudgets().then((budgets) => {
        this.budgets = budgets
        this.addBudgetOptions(budgets)
      })
    },
    fetchTargets() {
      return this.$fetchTargets().then((targets) => {
        this.targets = targets
      })
    },
    addPrefectureOptions(prefectures) {
      prefectures.map((prefecture) => {
        this.prefectureOptions.push({
          value: prefecture.id,
          text: prefecture.name,
          selected: false,
        })
      })
    },
    addBudgetOptions(budgets) {
      budgets.map((budget) => {
        this.budgetOptions.push({
          value: budget.id,
          text: budget.range,
          selected: false,
        })
      })
    },
    post(payload) {
      return this.$post(payload)
        .then(() => {
          this.$router.push('/tl')
        })
        .catch(() => {
          this.error = true
        })
    },
    onSubmit(e) {
      this.error = false
      const payload = {
        title: e.target.title.value,
        prefecture_id: Number(e.target.prefecture.value),
        budget_id: Number(e.target.budget.value),
        target_id: Number(e.target.target.value),
        flow_chart: this.$refs.flowChart.getShapedTree(),
      }
      this.loading = true
      this.post(payload).finally(() => {
        this.loading = false
      })
    },
    validateTitle(value) {
      this.validate.title = value.length > 0
    },
    validatePrefecture(value) {
      this.validate.prefecture = value > 0
    },
    validateBudget(value) {
      this.validate.budget = value > 0
    },
    canPost() {
      if (
        this.validate.title &&
        this.validate.prefecture &&
        this.validate.budget
      )
        return true
      return false
    },
  },
}
</script>

<style lang="scss" scoped>
.form {
  font-size: 14px;
  padding: 15px 0 0;

  &-links {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0 0 20px;

    & .link {
      color: $black;
      text-decoration: none;
    }
  }

  &-item {
    margin: 0 0 20px;
  }

  &-radio {
    display: flex;
    align-items: center;
    margin: 0 0 25px;

    & div {
      margin-right: 10px;

      &:last-of-type {
        margin-right: 0;
      }
    }
  }
}

.error {
  &-msg {
    color: $red;
    font-size: 14px;
    text-align: center;
    margin: 0 0 20px;
  }
}

.flow {
  &-text {
    margin: 0 0 10px;
  }

  &-chart {
    overflow: scroll;
    height: calc(100vh - 340px);
    min-height: 350px;
    margin: 0 15px 15px;
  }
}
</style>
