<div class="tabs">
	<ul class="nav nav-tabs">
		<li class="<?=(isset($request['type']) && $request['type'] != 'WHEELS' ? 'active' : '');?>"><a href="#tires" data-toggle="tab"><span>Типоразмеры шин</span></a></li>
		<li class="product_reviews_tab<?=(isset($request['type']) && $request['type'] == 'WHEELS' ? ' active' : '');?>"><a href="#wheels" data-toggle="tab"><span>Параметры дисков</span></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane<?=(isset($request['type']) && $request['type'] != 'WHEELS' ? ' active' : '');?>" id="tires">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h5>Типоразмер указан в маркировке на боковине шины:</h5>
					<p><span>Ширина профиля шины</span> — первое число в маркировке, например 195/50 R16 - ширина 195 мм. Ширина профиля представляет собой выраженное в миллиметрах расстояние между наружными сторонами боковин накачанной шины.</p>
					<p><span>Высота профиля</span> — второе число в маркировке шин, например 195/50 R16 - высота 50%. Это отношение высоты шины к ширине, выраженное в процентах (%).</p>
					<p><span>Монтажный диаметр</span> — третье число в маркировке шины, например 195/50 R16 - диаметр обода 16'. Должен совпадать с монтажным диаметром колесного диска. Измеряется в дюймах.</p>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="image"><img class="img-responsive" src="<?=str_replace("//", "/", SITE_DIR);?>include/filter_all_hint/1.png" alt="1.png" title="1.png"></div>
				</div>
			</div>
		</div>
		<div class="tab-pane<?=(isset($request['type']) && $request['type'] == 'WHEELS' ? ' active' : '');?>" id="wheels">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h5>Все диски имеют стандартную маркировку:</h5>
					<p><span>Ширина обода (B)</span> — колесного диска, измеренная в дюймах (6.5&rdquo;)</p>
					<p><span>Диаметр обода (D)</span> — монтажный диаметр обода колесного диска, измеренный в дюймах (15&rdquo;)</p>
					<p><span>PCD</span> — диаметр расположения центров крепежных отверстий на колесном диске (5x114.3)</p>
					<p><span>Вылет (ET)</span> — расстояние между продольной плоскостью симметрии диска и крепежной плоскостью колеса (45)</p>
					<p><span>DIA</span> — диаметр центрального отверстия под ступицу (54.1)</p>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="image"><img class="img-responsive" src="<?=str_replace("//", "/", SITE_DIR);?>include/filter_all_hint/2.png" alt="2.png" title="2.png"></div>
				</div>
			</div>		
		</div>	
	</div>
</div>