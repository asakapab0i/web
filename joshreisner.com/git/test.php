<?php

//new idea

echo passthru('cd /home/joshuareisner/git/test;pwd;git fetch upstream;git merge upstream/master;git archive master | tar -x -C /home/joshuareisner/test;');

/*
echo passthru('cd /home/joshuareisner/git/test');
echo passthru('pwd');
echo passthru('git fetch upstream');
echo passthru('git merge upstream/master');
echo passthru('git archive master | tar -x -C /home/joshuareisner/test');
*/
