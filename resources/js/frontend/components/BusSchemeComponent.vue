<template>
	<div>
		<button type="button" class="btn btn-outline-primary mr-4" data-toggle="modal" data-target="#exampleModal">
			Схема рассадки
		</button>
		<div class="modal modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Схема рассадки (Ещё не реализовано)</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<img src="/img/frontend/bus-scheme.png" alt="">Это картинка
						<br>Продажа туров может происходит с привязкой к свободным местам в автобусе или другом транспорте. 
						<br>Схемы транспорта прикрепляются к Расписанию тура на каждую дату и время. 
						<br>Схемы автотранспорта создаются  индивидуально для каждой транспортной единицы. 
						<br>У каждого поставщика  собственный набор схем автотранспорта.  
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
						<button type="button" class="btn btn-primary">Сохранить</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {

  name: 'BusSchemeComponent',

  data() {
    return {

    };
  },
};
</script>

<style lang="css" scoped>
</style>
