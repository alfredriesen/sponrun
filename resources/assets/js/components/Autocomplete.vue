<template>
	<v-select v-model="projectSelected" :options="projectItems">
	</v-select>
</template>

<script>
export default {
	name: "Autocomplete",
	props: {
		projects: {
			type: Object,
			default: ()=>{},
		},
		projectId: {
			type: Number,
			default: '',
		}
	},
	data () {
		let projectItems = Object.keys(this.projects).map((projectId)=>{
			return {
				label: this.projects[projectId],
				id: parseInt(projectId),
			}
		})
		let projectSelected = projectItems.find((project)=>project.id===this.projectId)
		return {
			projectSelected,
			projectItems,
		}
	},
	watch: {
		projectSelected (val) {
			document.getElementById('project_id').value = val.id
		}
	},
}
</script>

<style scoped>
</style>
