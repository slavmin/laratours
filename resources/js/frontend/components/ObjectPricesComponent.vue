<template>
	<div>
		<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
			Цены
		</button>
		<div class="modal modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Расценки (Ещё не реализовано)</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Стоимость аренды, период действия цены, класс обслуживания 
						<br>Цена за 1 час 
						<br>Цена за 3 часа 
						<br>Цена за 8 часов 
						<br>Цена за сутки  (могут добавлять нужный параметр цены; 
						<br> если указано несколько классов обслуживания — могут прописать новые цены на каждый класс обслуживания; 
						<br>могут задать действие цены на определенный календарный период времени (т. е. В течении года может быть несколько периодов действия цены, например: с 1.01 по 10.01 одна цена, с 11.01 по 30.04 — другая цена, с 1.05 по  11.05 третья цена и т. д. ;
						могут скопировать — установить периоды — уже из заполненного предыдущего класса обслуживания). 
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

  name: 'ObjectPricesComponent',

  data() {
    return {

    };
  },
};
</script>

<style lang="css" scoped>
</style>
