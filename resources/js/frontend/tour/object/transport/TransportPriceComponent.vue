<template>
	<div>
		<a href="#" data-toggle="modal" data-target="#exampleModal">
			Цены
		</a>
		<!-- Modal wrap -->
		<div class="modal fade wrap" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<!-- Modal header -->
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Цены</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<!-- /Modal header -->
					<!-- Modal body -->
					<div class="modal-body">
						<!-- Date range -->
						<div class="input-group mb-3">
							<input type="text" class="form-control" :value="currentDateRange">
							<div class="input-group-append">
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать период</button>
								<div class="dropdown-menu">
								  	<a 
								  		class="dropdown-item" 
								  		href="#"
								  		v-for="range, i in dateRanges"
										:key="i"
										v-on:click="changeCurrentDateRange(range)"
								  	>
										{{range}}
									</a>
								</div>
							</div>
						</div>
						<!-- /Date range -->
						<!-- Price input fields -->
						<div 
							class="input-group mb-3"
							v-for="interval, i in timeIntervals"
							:key="i"
						>
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1" style="min-width: 80px;">{{ interval }}</span>
							</div>
							<input type="text" class="form-control" placeholder="Введите цену" :value="i">
							<div class="input-group-append">
								<span class="input-group-text">₽</span>
							</div>
						</div>
						<!-- /Price input fields -->
					</div>
					<!-- /Modal body -->
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
						<button type="button" class="btn btn-primary">Сохранить</button>
					</div>
					<!-- /Modal footer -->
				</div>
			</div>
		</div>
		<!-- /Modal wrap -->
	</div>
</template>

<script>
export default {

name: 'TransportPriceComponent',

	data() {
		return {
			timeIntervals: ['1 час', '3 часа', '8 часов', '24 часа'],
			dateRanges: [
				'1 января - 10 января',
				'11 января - 30 апреля',
				'1 мая - 11 мая',
				'12 мая - 10 июня',
				'11 июня - 14 июня',
				'14 июня - 31 августа',
				'1 сентября - 31 декабря'
			],
			currentDateRange: '',
			examplePrice: {
				'1 января - 10 января': ['1000', '2000', '5000', '15000'],
				'11 января - 30 апреля': ['900', '1800', '4000', '13000']
			},
			0: '1',
			1: '2',
			2: '3',
			3: '4'
		};
	},
	created() {
		// console.log('hello from transport price component')
		// console.log(this.examplePrice)
	},
	methods: {
		changeCurrentDateRange(range) {
			this.currentDateRange = range
			console.log(this.examplePrice)
		}
	}
};
</script>

<style lang="scss" scoped>
.wrap {
	color: black;
}
</style>
