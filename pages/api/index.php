<!DOCTYPE html>
<html>

<head>
	<?php getHead(); ?>
	<title>TesTubes - API</title>
	<style type="text/css">

	body{
		background-color: rgb(65, 65, 65);
	}

	.container{
		height: 100vh;
		background-color: rgb(242, 242, 242);
	}

	.method{
		box-shadow: inset 0 0 0 1px rgba(0,0,0,.15);
    	border-radius: 4px;
		background: #fff;
    	border: solid rgb(200, 200, 200) 1px;
    	color: #737373;
	}

	.return-type, .param-type{
		color: #693;
	}

	.method-name, .param-name{
		color: rgb(51, 102, 153);
	}

	.param-default{
		color: #936;
	}

	</style>
</head>

<body>
	
	<?php 
		$class = "API";
		$methods = get_class_methods($class);
		$reflection = new ReflectionClass($class);
		$methods = $reflection->getMethods();
	?>
	<div class="container">

		<h1>API Reference</h1>
		
		<hr>

		<?php foreach($methods as $method):

			if($method->isConstructor() || $method->isPrivate()) continue; ?>

			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<div class="method p-2">
						<span class="return-type"><?= $method->getReturnType() ?></span>
						
						<?php $params = $method->getParameters(); ?>
						<?php 
						$urlParam = count($params) > 0 ? "?" : "";
						foreach($params as $param){
							$urlParam .= $param->getName() . "=" . $param->getDefaultValue();
						}
						?>
						<a href="<?=ABSURL?>api/<?= $method->getName() . $urlParam ?>" class="method-name"><?= $method->getName() ?></a> (

						<?php foreach($params as $index => $param): ?>
							<?php if($param->isOptional()): ?>
								[
							<?php endif; ?>
							<?php if($index != 0): ?>
								,
							<?php endif; ?>
							<span class="param-type"><?= $param->getType() ?></span> 
							<span class="param-name">$<?= $param->getName() ?></span>
							<?php if($param->isOptional()): ?>
								<span class="param-default">= 
									<?php if(is_null($param->getDefaultValue())): ?>
										null
									<?php elseif(is_string($param->getDefaultValue())): ?>
										"<?= $param->getDefaultValue() ?>"
									<?php else: ?>
										<?= $param->getDefaultValue() ?>
									<?php endif; ?>
								</span>
								]
							<?php endif; ?>
						<?php endforeach; ?>

						)
					</div>
					<p><?= str_replace("@param", "<br>&nbsp;-&nbsp;", str_replace("/", "", preg_replace("/\*/", "", $method->getDocComment()))) ?></p>
				</div>
				<div class="col-2"></div>
			</div>
		<?php endforeach;?>
		
	</div>

</body>

</html>