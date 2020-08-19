#!/usr/bin/env python

import sys
from mako.template import Template

for curarg in sys.argv[1:]:
    modelname=curarg
    if modelname[-4:]=='.php':
        modelname=modelname[:-4]
    if modelname[-11:]=='_controller':
        modelname=modelname[:-11]
    fileout=modelname+'_controller.test.php'
    xmlfile = Template(filename='testcontroller')
    fout=open(fileout,'w')
    output=xmlfile.render(modelname=modelname)
    fout.write(output)
    fout.close()
