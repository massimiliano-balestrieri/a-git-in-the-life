#!/bin/sed -f
#< Remove C/C++ comments from files
# Another way to do it - adapted from a script found here
# http://sed.sourceforge.net/grabbag/scripts/remccoms1.sed
# to allow c++ // style comments to be removed
#
# c++ // comment removal code added KW 01/11/04
# comments added KW 02/11/04

# If pattern is not matched (i.e. line does not contain /*
# then branch to label :c

s/.$//
s:\r::
s:\n::
