<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
        <h6 class="p-15">
          Skills Filter
        </h6>
      </div>
      <template slot="options">
        <button type="button" v-on:click="close" class="btn btn-light">
          <i class="fa fa-close" aria-hidden="true"></i>
        </button>
      </template>
      <div class="modal-body">
        <skill-selector :selectOnly="true" ref="skill-selector" :form="form">
          <div class="border-top pt-3">
            <button class="btn btn-primary pull-right" @click="filter">Filter</button>
          </div>
        </skill-selector>
      </div>
  </sidebar-popup>
</template>

<script>
import SkillSelector from '~/components/SkillSelector'
import Form from 'vform'
import SidebarPopup from '~/components/SidebarPopup'

export default {
  components: {
    SkillSelector,
    SidebarPopup
  },
  props: {
    form: {
      type: Object,
      required: true
    }
  },
  data : () =>({
    programming_languages: window.config.programming_languages,
    technologies: window.config.technologies,
  }),
  methods: {
    show(techs, langs){
      this.$refs.modal.show()
      this.$refs['skill-selector'].updateTechnologies(techs);
      this.$refs['skill-selector'].updateProgrammingLanguages(langs)
    },
    filter(){
      this.$refs.modal.hide()
      this.$emit('update', {
        technologies: this.getMatchTechnologies(),
        programming_languages: this.getMatchProgrammingLanguage()
      })
    },
    getMatchProgrammingLanguage(){
      var result = [];
      for(var i = 0; i < this.form.skills.programming_languages.length; i++){
        for(var x = 0; x < this.programming_languages.length; x++){
          if(this.form.skills.programming_languages[i] == this.programming_languages[x].id){
            result.push(this.programming_languages[x]);
            x == this.programming_languages.length
          }
        }
      }
      return result;
    },
    getMatchTechnologies(){
      var result = [];
      for(var i = 0; i < this.form.skills.technologies.length; i++){
        for(var x = 0; x < this.technologies.length; x++){
          if(this.form.skills.technologies[i] == this.technologies[x].id){
            result.push(this.technologies[x]);
            x == this.technologies.length
          }
        }
      }
      return result;
    },
    close(){
      this.$refs.modal.hide()
    }
  },
  mounted(){
    // 
  }
}
</script>
