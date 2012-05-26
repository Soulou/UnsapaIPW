TOPDF=pdflatex
TARGET=report.pdf

all: report.tex
	$(TOPDF) $<
	mv report.pdf ../pdf/

clean:
	@rm *.toc *.aux *.log *.out *.pdf
