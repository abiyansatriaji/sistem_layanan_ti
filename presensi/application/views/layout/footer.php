</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){var el=document.getElementById('clock');if(!el)return;
function tick(){var d=new Date();el.textContent=[d.getHours(),d.getMinutes(),d.getSeconds()].map(function(n){return String(n).padStart(2,'0')}).join(':');}
tick();setInterval(tick,1000);})();
</script>
</body>
</html>
