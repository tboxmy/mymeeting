#!/usr/bin/env python

import sys
from mako.template import Template

for curarg in sys.argv[1:]:
    modelname=curarg
    if modelname[-4:]=='.php':
        modelname=modelname[:-4]
    fileout=modelname+'.test.php'
    xmlfile = Template(filename='testmodel')
    fout=open(fileout,'w')
    output=xmlfile.render(modelname=modelname)
    fout.write(output)
    fout.close()
