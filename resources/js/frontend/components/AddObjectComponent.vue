<template>
	<div>
		<!-- Add button -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addObjectModal">
			Добавить {{ type.toLowerCase() }}
		</button>
		<!-- /Add button -->

		<!-- Modal -->
		<div class="modal fade" id="addObjectModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
			    <div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Создать новый {{ type.toLowerCase() }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="http://127.0.0.1:8000/operator/transport">
                			<input type="hidden" name="_token" :value="token">
							<div class="form-group">
								<label for="name">Название</label>
								<input type="text" class="form-control" name="name" id="name" required autofocus>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
								    	<span class="input-group-text">Страна и город</span>
									</div>
									<select 
										name="country" 
										id="country" 
										class="form-control"
										@change="selectCountry($event)"
										v-model="key"
									>
										<option
											v-for="country, i in citiesSelect"
											:value="i" 
										>
											{{ i }}
										</option>
									</select>
									<select name="city_id" id="city_id" class="form-control">
									<option
										v-for="city, i in cities.Россия"
										:key="city" 
										:value="i" 
									>
										{{ city }}
									</option>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label for="qnt">Вместимость</label>
								<input type="text" class="form-control" name="qnt" id="qnt">
							</div>
							<div class="form-group">
								<label for="description">Описание</label>
								<input type="text" class="form-control" name="description" id="description">
							</div>
							<div class="form-group">
								<label for="grade">Класс обслуживания</label>
								<select class="custom-select" name="grade" id="grade" multiple>
									<option>Стандарт</option>
									<option>C-class</option>
									<option>VIP</option>
								</select>
							</div>
							<div class="input-group mb-3">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04">
									<label class="custom-file-label" for="inputGroupFile04">Фото</label>
								</div>
								<div class="input-group-append">
									<button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Загрузить</button>
								</div>
							</div>
							<div class="row container mb-4">
								<!-- <object-prices-component></object-prices-component>	 -->
								<bus-scheme-component></bus-scheme-component>		
								<button type="button" class="btn btn-outline-primary" v-on:click="showPrices = !showPrices">
									Цены
								</button>					
							</div>	
							<div class="row container mb-4" v-if="showPrices">
								Стоимость аренды, период действия цены, класс обслуживания 
								<br>Цена за 1 час 
								<br>Цена за 3 часа 
								<br>Цена за 8 часов 
								<br>Цена за сутки  (могут добавлять нужный параметр цены;
							</div>
							<button type="submit" class="btn btn-primary">Создать</button>				
						</form>
					</div>
			    </div>
		  	</div>
		</div>
		<!-- /Modal -->
	</div>
</template>

<script>
export default {

  name: 'AddObjectComponent',
  props: ['type', 'fieldName', 'fields', 'token', 'citiesSelect'],

  data() {
    return {
    	name: 'Add Object',
    	selectedCountry: 'Россия',
    	key: '',
    	cities: this.citiesSelect,
    	testObject: {
    		'0': 'default',
    		'Россия': {
    			'1': 'Москва',
    			'2': 'СПб'
    		},
    		'Чехия': {
    			'3': 'Прага'
    		}
    	},
    	showPrices: false
    }
  },
  created() {
  	// console.log(this.testObject)
  	// this.createCitiesObject()
  },
  updated() {
  	// console.log(this.selectedCountry)
  },
  methods: {
  	createCitiesObject() {
  		// console.log(this.citiesSelect)
  	},
  	selectCountry:function(event) {
  		this.selectedCountry = event.target.value
  		console.log(this.citiesSelect)
  		// console.log(this.citiesSelect.map(this.selectedCountry))
  	}
  }
};
</script>

<style lang="css" scoped>
</style>
