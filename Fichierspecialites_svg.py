#!/usr/bin/env python
# encoding: utf-8
# Généré par Mocodo 2.3.7 le Mon, 21 Feb 2022 04:34:22

from __future__ import division
from math import hypot

import time, codecs

import json

with codecs.open('Fichierspecialites_geo.json') as f:
    geo = json.loads(f.read())
(width,height) = geo.pop('size')
for (name, l) in geo.items(): globals()[name] = dict(l)
card_max_width = 22
card_max_height = 15
card_margin = 5
arrow_width = 12
arrow_half_height = 6
arrow_axis = 8
card_baseline = 3

def cmp(x, y):
    return (x > y) - (x < y)

def offset(x, y):
    return (x + card_margin, y - card_baseline - card_margin)

def line_intersection(ex, ey, w, h, ax, ay):
    if ax == ex:
        return (ax, ey + cmp(ay, ey) * h)
    if ay == ey:
        return (ex + cmp(ax, ex) * w, ay)
    x = ex + cmp(ax, ex) * w
    y = ey + (ay-ey) * (x-ex) / (ax-ex)
    if abs(y-ey) > h:
        y = ey + cmp(ay, ey) * h
        x = ex + (ax-ex) * (y-ey) / (ay-ey)
    return (x, y)

def straight_leg_factory(ex, ey, ew, eh, ax, ay, aw, ah, cw, ch):
    
    def card_pos(twist, shift):
        compare = (lambda x1_y1: x1_y1[0] < x1_y1[1]) if twist else (lambda x1_y1: x1_y1[0] <= x1_y1[1])
        diagonal = hypot(ax-ex, ay-ey)
        correction = card_margin * 1.4142 * (1 - abs(abs(ax-ex) - abs(ay-ey)) / diagonal) - shift
        (xg, yg) = line_intersection(ex, ey, ew, eh + ch, ax, ay)
        (xb, yb) = line_intersection(ex, ey, ew + cw, eh, ax, ay)
        if compare((xg, xb)):
            if compare((xg, ex)):
                if compare((yb, ey)):
                    return (xb - correction, yb)
                return (xb - correction, yb + ch)
            if compare((yb, ey)):
                return (xg, yg + ch - correction)
            return (xg, yg + correction)
        if compare((xb, ex)):
            if compare((yb, ey)):
                return (xg - cw, yg + ch - correction)
            return (xg - cw, yg + correction)
        if compare((yb, ey)):
            return (xb - cw + correction, yb)
        return (xb - cw + correction, yb + ch)
    
    def arrow_pos(direction, ratio):
        (x0, y0) = line_intersection(ex, ey, ew, eh, ax, ay)
        (x1, y1) = line_intersection(ax, ay, aw, ah, ex, ey)
        if direction == "<":
            (x0, y0, x1, y1) = (x1, y1, x0, y0)
        (x, y) = (ratio * x0 + (1 - ratio) * x1, ratio * y0 + (1 - ratio) * y1)
        return (x, y, x1 - x0, y0 - y1)
    
    straight_leg_factory.card_pos = card_pos
    straight_leg_factory.arrow_pos = arrow_pos
    return straight_leg_factory


def curved_leg_factory(ex, ey, ew, eh, ax, ay, aw, ah, cw, ch, spin):
    
    def bisection(predicate):
        (a, b) = (0, 1)
        while abs(b - a) > 0.0001:
            m = (a + b) / 2
            if predicate(bezier(m)):
                a = m
            else:
                b = m
        return m
    
    def intersection(left, top, right, bottom):
       (x, y) = bezier(bisection(lambda p: left <= p[0] <= right and top <= p[1] <= bottom))
       return (int(round(x)), int(round(y)))
    
    def card_pos(shift):
        diagonal = hypot(ax-ex, ay-ey)
        correction = card_margin * 1.4142 * (1 - abs(abs(ax-ex) - abs(ay-ey)) / diagonal)
        (top, bot) = (ey - eh, ey + eh)
        (TOP, BOT) = (top - ch, bot + ch)
        (lef, rig) = (ex - ew, ex + ew)
        (LEF, RIG) = (lef - cw, rig + cw)
        (xr, yr) = intersection(LEF, TOP, RIG, BOT)
        (xg, yg) = intersection(lef, TOP, rig, BOT)
        (xb, yb) = intersection(LEF, top, RIG, bot)
        if spin > 0:
            if (yr == BOT and xr <= rig) or (xr == LEF and yr >= bot):
                return (max(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y >= bot) - correction + shift, bot + ch)
            if (xr == RIG and yr >= top) or yr == BOT:
                return (rig, min(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x >= rig) + correction + shift)
            if (yr == TOP and xr >= lef) or xr == RIG:
                return (min(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y <= top) + correction + shift - cw, TOP + ch)
            return (LEF, max(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x <= lef) - correction + shift + ch)
        if (yr == BOT and xr >= lef) or (xr == RIG and yr >= bot):
            return (min(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y >= bot) + correction + shift - cw, bot + ch)
        if xr == RIG or (yr == TOP and xr >= rig):
            return (rig, max(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x >= rig) - correction + shift + ch)
        if yr == TOP or (xr == LEF and yr <= top):
            return (max(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y <= top) - correction + shift, TOP + ch)
        return (LEF, min(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x <= lef) + correction + shift)
    
    def arrow_pos(direction, ratio):
        t0 = bisection(lambda p: abs(p[0] - ax) > aw or abs(p[1] - ay) > ah)
        t3 = bisection(lambda p: abs(p[0] - ex) < ew and abs(p[1] - ey) < eh)
        if direction == "<":
            (t0, t3) = (t3, t0)
        tc = t0 + (t3 - t0) * ratio
        (xc, yc) = bezier(tc)
        (x, y) = derivate(tc)
        if direction == "<":
            (x, y) = (-x, -y)
        return (xc, yc, x, -y)
    
    diagonal = hypot(ax - ex, ay - ey)
    (x, y) = line_intersection(ex, ey, ew + cw / 2, eh + ch / 2, ax, ay)
    k = (cw *  abs((ay - ey) / diagonal) + ch * abs((ax - ex) / diagonal))
    (x, y) = (x - spin * k * (ay - ey) / diagonal, y + spin * k * (ax - ex) / diagonal)
    (hx, hy) = (2 * x - (ex + ax) / 2, 2 * y - (ey + ay) / 2)
    (x1, y1) = (ex + (hx - ex) * 2 / 3, ey + (hy - ey) * 2 / 3)
    (x2, y2) = (ax + (hx - ax) * 2 / 3, ay + (hy - ay) * 2 / 3)
    (kax, kay) = (ex - 2 * hx + ax, ey - 2 * hy + ay)
    (kbx, kby) = (2 * hx - 2 * ex, 2 * hy - 2 * ey)
    bezier = lambda t: (kax*t*t + kbx*t + ex, kay*t*t + kby*t + ey)
    derivate = lambda t: (2*kax*t + kbx, 2*kay*t + kby)
    
    curved_leg_factory.points = (ex, ey, x1, y1, x2, y2, ax, ay)
    curved_leg_factory.card_pos = card_pos
    curved_leg_factory.arrow_pos = arrow_pos
    return curved_leg_factory


def upper_round_rect(x, y, w, h, r):
    return " ".join([str(x) for x in ["M", x + w - r, y, "a", r, r, 90, 0, 1, r, r, "V", y + h, "h", -w, "V", y + r, "a", r, r, 90, 0, 1, r, -r]])

def lower_round_rect(x, y, w, h, r):
    return " ".join([str(x) for x in ["M", x + w, y, "v", h - r, "a", r, r, 90, 0, 1, -r, r, "H", x + r, "a", r, r, 90, 0, 1, -r, -r, "V", y, "H", w]])

def arrow(x, y, a, b):
    c = hypot(a, b)
    (cos, sin) = (a / c, b / c)
    return " ".join([str(x) for x in [ "M", x, y, "L", x + arrow_width * cos - arrow_half_height * sin, y - arrow_half_height * cos - arrow_width * sin, "L", x + arrow_axis * cos, y - arrow_axis * sin, "L", x + arrow_width * cos + arrow_half_height * sin, y + arrow_half_height * cos - arrow_width * sin, "Z"]])

def safe_print_for_PHP(s):
    try:
        print(s)
    except UnicodeEncodeError:
        print(s.encode("utf8"))


lines = '<?xml version="1.0" standalone="no"?>\n<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"\n"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'
lines += '\n\n<svg width="%s" height="%s" view_box="0 0 %s %s"\nxmlns="http://www.w3.org/2000/svg"\nxmlns:link="http://www.w3.org/1999/xlink">' % (width,height,width,height)
lines += u'\\n\\n<desc>Généré par Mocodo 2.3.7 le %s</desc>' % time.strftime("%a, %d %b %Y %H:%M:%S", time.localtime())
lines += '\n\n<rect id="frame" x="0" y="0" width="%s" height="%s" fill="%s" stroke="none" stroke-width="0"/>' % (width,height,colors['background_color'] if colors['background_color'] else "none")

lines += u"""\n\n<!-- Association DONNE AVIS SMR SUR -->"""
(x,y) = (cx[u"DONNE AVIS SMR SUR"],cy[u"DONNE AVIS SMR SUR"])
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,77,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"DONNE AVIS SMR SUR,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"AvisServiceMédicalRendu"],cy[u"AvisServiceMédicalRendu"])
leg=straight_leg_factory(ex,ey,160,68,x,y,77,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(True,shift[u"DONNE AVIS SMR SUR,AvisServiceMédicalRendu"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-DONNE AVIS SMR SUR">""" % {}
path = upper_round_rect(-77+x,-25+y,154,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-77+x,0.0+y,154,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="154" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -77+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -77+x, 'y0': 0+y, 'x1': 77+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">DONNE AVIS SMR SUR</text>""" % {'x': -70+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association CONCERNE -->"""
(x,y) = (cx[u"CONCERNE"],cy[u"CONCERNE"])
(ex,ey) = (cx[u"ConditionPrescriptionDélivrance"],cy[u"ConditionPrescriptionDélivrance"])
leg=straight_leg_factory(ex,ey,133,34,x,y,42,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"CONCERNE,ConditionPrescriptionDélivrance"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,42,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"CONCERNE,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-CONCERNE">""" % {}
path = upper_round_rect(-42+x,-25+y,84,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-42+x,0.0+y,84,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="84" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -42+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -42+x, 'y0': 0+y, 'x1': 42+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">CONCERNE</text>""" % {'x': -35+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association DONNE INFO IMPORTANTES -->"""
(x,y) = (cx[u"DONNE INFO IMPORTANTES"],cy[u"DONNE INFO IMPORTANTES"])
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,93,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"DONNE INFO IMPORTANTES,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"InfoImportantes"],cy[u"InfoImportantes"])
leg=straight_leg_factory(ex,ey,164,51,x,y,93,25,21+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"DONNE INFO IMPORTANTES,InfoImportantes"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,1</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-DONNE INFO IMPORTANTES">""" % {}
path = upper_round_rect(-93+x,-25+y,186,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-93+x,0.0+y,186,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="186" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -93+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -93+x, 'y0': 0+y, 'x1': 93+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">DONNE INFO IMPORTANTES</text>""" % {'x': -86+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association ÊTRE LE GÉNÉRIQUE DE -->"""
(x,y) = (cx[u"ÊTRE LE GÉNÉRIQUE DE"],cy[u"ÊTRE LE GÉNÉRIQUE DE"])
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,81,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"ÊTRE LE GÉNÉRIQUE DE,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"GroupesGénériques"],cy[u"GroupesGénériques"])
leg=straight_leg_factory(ex,ey,102,59,x,y,81,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"ÊTRE LE GÉNÉRIQUE DE,GroupesGénériques"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-ÊTRE LE GÉNÉRIQUE DE">""" % {}
path = upper_round_rect(-81+x,-25+y,162,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-81+x,0.0+y,162,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="162" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -81+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -81+x, 'y0': 0+y, 'x1': 81+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">ÊTRE LE GÉNÉRIQUE DE</text>""" % {'x': -74+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association EST COMPOSÉ DE -->"""
(x,y) = (cx[u"EST COMPOSÉ DE"],cy[u"EST COMPOSÉ DE"])
(ex,ey) = (cx[u"Composition"],cy[u"Composition"])
leg=straight_leg_factory(ex,ey,131,85,x,y,62,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"EST COMPOSÉ DE,Composition"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,62,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"EST COMPOSÉ DE,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-EST COMPOSÉ DE">""" % {}
path = upper_round_rect(-62+x,-25+y,124,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-62+x,0.0+y,124,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="124" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -62+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -62+x, 'y0': 0+y, 'x1': 62+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">EST COMPOSÉ DE</text>""" % {'x': -55+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association ÊTRE SOURCE DE -->"""
(x,y) = (cx[u"ÊTRE SOURCE DE"],cy[u"ÊTRE SOURCE DE"])
(ex,ey) = (cx[u"AvisServiceMédicalRendu"],cy[u"AvisServiceMédicalRendu"])
leg=straight_leg_factory(ex,ey,160,68,x,y,61,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"ÊTRE SOURCE DE,AvisServiceMédicalRendu"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"AvisAméliorationSMR"],cy[u"AvisAméliorationSMR"])
leg=straight_leg_factory(ex,ey,160,68,x,y,61,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"ÊTRE SOURCE DE,AvisAméliorationSMR"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"LienAvisCommissionTransparence"],cy[u"LienAvisCommissionTransparence"])
leg=straight_leg_factory(ex,ey,110,34,x,y,61,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"ÊTRE SOURCE DE,LienAvisCommissionTransparence"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-ÊTRE SOURCE DE">""" % {}
path = upper_round_rect(-61+x,-25+y,122,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-61+x,0.0+y,122,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="122" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -61+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -61+x, 'y0': 0+y, 'x1': 61+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">ÊTRE SOURCE DE</text>""" % {'x': -54+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association DONNER AVIS ASMR SUR -->"""
(x,y) = (cx[u"DONNER AVIS ASMR SUR"],cy[u"DONNER AVIS ASMR SUR"])
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,85,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(True,shift[u"DONNER AVIS ASMR SUR,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"AvisAméliorationSMR"],cy[u"AvisAméliorationSMR"])
leg=straight_leg_factory(ex,ey,160,68,x,y,85,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"DONNER AVIS ASMR SUR,AvisAméliorationSMR"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-DONNER AVIS ASMR SUR">""" % {}
path = upper_round_rect(-85+x,-25+y,170,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-85+x,0.0+y,170,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="170" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -85+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -85+x, 'y0': 0+y, 'x1': 85+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">DONNER AVIS ASMR SUR</text>""" % {'x': -78+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association A ACCÈS À -->"""
(x,y) = (cx[u"A ACCÈS À"],cy[u"A ACCÈS À"])
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,41,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"A ACCÈS À,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Utilisateur"],cy[u"Utilisateur"])
leg=straight_leg_factory(ex,ey,43,68,x,y,41,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"A ACCÈS À,Utilisateur"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-A ACCÈS À">""" % {}
path = upper_round_rect(-41+x,-25+y,82,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-41+x,0.0+y,82,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="82" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -41+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -41+x, 'y0': 0+y, 'x1': 41+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">A ACCÈS À</text>""" % {'x': -34+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association INFORME SUR -->"""
(x,y) = (cx[u"INFORME SUR"],cy[u"INFORME SUR"])
(ex,ey) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
leg=straight_leg_factory(ex,ey,144,110,x,y,51,25,21+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"INFORME SUR,FichierSpécialité"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,1</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"FichierPrésentation"],cy[u"FichierPrésentation"])
leg=straight_leg_factory(ex,ey,138,102,x,y,51,25,22+2*card_margin,15+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"INFORME SUR,FichierPrésentation"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Verdana" font-size="12">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-INFORME SUR">""" % {}
path = upper_round_rect(-51+x,-25+y,102,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-51+x,0.0+y,102,25,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="102" height="50" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -51+x, 'y': -25+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -51+x, 'y0': 0+y, 'x1': 51+x, 'y1': 0+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">INFORME SUR</text>""" % {'x': -44+x, 'y': -7.3+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity FichierSpécialité -->"""
(x,y) = (cx[u"FichierSpécialité"],cy[u"FichierSpécialité"])
lines += u"""\n<g id="entity-FichierSpécialité">""" % {}
lines += u"""\n	<g id="frame-FichierSpécialité">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="288" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -144+x, 'y': -110+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="288" height="195" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -144+x, 'y': -85.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="288" height="220" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -144+x, 'y': -110+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -144+x, 'y0': -85+y, 'x1': 144+x, 'y1': -85+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">FichierSpécialité</text>""" % {'x': -50+x, 'y': -92.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIS</text>""" % {'x': -139+x, 'y': -67.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -139+x, 'y0': -65+y, 'x1': -82+x, 'y1': -65+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Dénomination du médicament</text>""" % {'x': -139+x, 'y': -50.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Forme pharmaceutique</text>""" % {'x': -139+x, 'y': -33.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Voies d'administration</text>""" % {'x': -139+x, 'y': -16.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Statut administratif de l’AMM</text>""" % {'x': -139+x, 'y': 0.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Type de procédure d'AMM</text>""" % {'x': -139+x, 'y': 17.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Etat de commercialisation</text>""" % {'x': -139+x, 'y': 34.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Date d’AMM (format JJ/MM/AAAA)</text>""" % {'x': -139+x, 'y': 51.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">StatutBdm : «Alerte»/ «disponibilité »</text>""" % {'x': -139+x, 'y': 68.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Titulaire(s)</text>""" % {'x': -139+x, 'y': 85.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Surveillance renforcée (triangle noir) Oui/Non</text>""" % {'x': -139+x, 'y': 102.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity InfoImportantes -->"""
(x,y) = (cx[u"InfoImportantes"],cy[u"InfoImportantes"])
lines += u"""\n<g id="entity-InfoImportantes">""" % {}
lines += u"""\n	<g id="frame-InfoImportantes">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="328" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -164+x, 'y': -51+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="328" height="77" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -164+x, 'y': -26.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="328" height="102" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -164+x, 'y': -51+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -164+x, 'y0': -26+y, 'x1': 164+x, 'y1': -26+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">InfoImportantes</text>""" % {'x': -50+x, 'y': -33.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIS</text>""" % {'x': -159+x, 'y': -8.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -159+x, 'y0': -6+y, 'x1': -102+x, 'y1': -6+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Date de début de l’information de sécurité</text>""" % {'x': -159+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Date de fin de l’information de sécurité</text>""" % {'x': -159+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Texte à afficher et lien vers l’information de sécurité</text>""" % {'x': -159+x, 'y': 42.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Utilisateur -->"""
(x,y) = (cx[u"Utilisateur"],cy[u"Utilisateur"])
lines += u"""\n<g id="entity-Utilisateur">""" % {}
lines += u"""\n	<g id="frame-Utilisateur">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="86" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -43+x, 'y': -68+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="86" height="111" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -43+x, 'y': -43.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="86" height="136" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -43+x, 'y': -68+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -43+x, 'y0': -43+y, 'x1': 43+x, 'y1': -43+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Utilisateur</text>""" % {'x': -31+x, 'y': -50.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">IdUtilisateur</text>""" % {'x': -38+x, 'y': -25.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -38+x, 'y0': -23+y, 'x1': 37+x, 'y1': -23+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Nom</text>""" % {'x': -38+x, 'y': -8.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Prénom</text>""" % {'x': -38+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Âge</text>""" % {'x': -38+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Allergies</text>""" % {'x': -38+x, 'y': 42.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Mail</text>""" % {'x': -38+x, 'y': 59.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity GroupesGénériques -->"""
(x,y) = (cx[u"GroupesGénériques"],cy[u"GroupesGénériques"])
lines += u"""\n<g id="entity-GroupesGénériques">""" % {}
lines += u"""\n	<g id="frame-GroupesGénériques">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="204" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -102+x, 'y': -59+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="204" height="93" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -102+x, 'y': -34.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="204" height="118" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -102+x, 'y': -59+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -102+x, 'y0': -34+y, 'x1': 102+x, 'y1': -34+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">GroupesGénériques</text>""" % {'x': -60+x, 'y': -41.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Identifiant du groupe générique</text>""" % {'x': -97+x, 'y': -16.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -97+x, 'y0': -14+y, 'x1': 96+x, 'y1': -14+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Libellé du groupe générique</text>""" % {'x': -97+x, 'y': 0.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIS</text>""" % {'x': -97+x, 'y': 17.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Type de générique</text>""" % {'x': -97+x, 'y': 34.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Numéro de tri</text>""" % {'x': -97+x, 'y': 51.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity ConditionPrescriptionDélivrance -->"""
(x,y) = (cx[u"ConditionPrescriptionDélivrance"],cy[u"ConditionPrescriptionDélivrance"])
lines += u"""\n<g id="entity-ConditionPrescriptionDélivrance">""" % {}
lines += u"""\n	<g id="frame-ConditionPrescriptionDélivrance">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="266" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -133+x, 'y': -34+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="266" height="43" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -133+x, 'y': -9.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="266" height="68" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -133+x, 'y': -34+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -133+x, 'y0': -9+y, 'x1': 133+x, 'y1': -9+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">ConditionPrescriptionDélivrance</text>""" % {'x': -96+x, 'y': -16.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIS</text>""" % {'x': -128+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -128+x, 'y0': 11+y, 'x1': -71+x, 'y1': 11+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Condition de prescription ou de délivrance</text>""" % {'x': -128+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity AvisAméliorationSMR -->"""
(x,y) = (cx[u"AvisAméliorationSMR"],cy[u"AvisAméliorationSMR"])
lines += u"""\n<g id="entity-AvisAméliorationSMR">""" % {}
lines += u"""\n	<g id="frame-AvisAméliorationSMR">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="320" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -160+x, 'y': -68+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="320" height="111" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -160+x, 'y': -43.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="320" height="136" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -160+x, 'y': -68+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -160+x, 'y0': -43+y, 'x1': 160+x, 'y1': -43+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">AvisAméliorationSMR</text>""" % {'x': -65+x, 'y': -50.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Id</text>""" % {'x': -155+x, 'y': -25.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -155+x, 'y0': -23+y, 'x1': -141+x, 'y1': -23+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code de dossier HAS</text>""" % {'x': -155+x, 'y': -8.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Motif d’évaluation</text>""" % {'x': -155+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Date de l’avis de la Commission de la transparence</text>""" % {'x': -155+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Valeur de l'ASMR</text>""" % {'x': -155+x, 'y': 42.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Libelle de l'ASMR</text>""" % {'x': -155+x, 'y': 59.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity FichierPrésentation -->"""
(x,y) = (cx[u"FichierPrésentation"],cy[u"FichierPrésentation"])
lines += u"""\n<g id="entity-FichierPrésentation">""" % {}
lines += u"""\n	<g id="frame-FichierPrésentation">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="276" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -138+x, 'y': -102+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="276" height="179" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -138+x, 'y': -77.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="276" height="204" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -138+x, 'y': -102+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -138+x, 'y0': -77+y, 'x1': 138+x, 'y1': -77+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">FichierPrésentation</text>""" % {'x': -58+x, 'y': -84.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIS</text>""" % {'x': -133+x, 'y': -59.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -133+x, 'y0': -57+y, 'x1': -76+x, 'y1': -57+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIP7</text>""" % {'x': -133+x, 'y': -42.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Libellé de la présentation</text>""" % {'x': -133+x, 'y': -25.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Statut administratif de la présentation</text>""" % {'x': -133+x, 'y': -8.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Etat de commercialisation</text>""" % {'x': -133+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Date de la déclaration de commercialisation</text>""" % {'x': -133+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIP13</text>""" % {'x': -133+x, 'y': 42.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Agrément aux collectivités</text>""" % {'x': -133+x, 'y': 59.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Taux de remboursement</text>""" % {'x': -133+x, 'y': 76.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Prix du médicament en euro</text>""" % {'x': -133+x, 'y': 93.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity LienAvisCommissionTransparence -->"""
(x,y) = (cx[u"LienAvisCommissionTransparence"],cy[u"LienAvisCommissionTransparence"])
lines += u"""\n<g id="entity-LienAvisCommissionTransparence">""" % {}
lines += u"""\n	<g id="frame-LienAvisCommissionTransparence">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="220" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -110+x, 'y': -34+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="220" height="43" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -110+x, 'y': -9.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="220" height="68" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -110+x, 'y': -34+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -110+x, 'y0': -9+y, 'x1': 110+x, 'y1': -9+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">LienAvisCommissionTransparence</text>""" % {'x': -103+x, 'y': -16.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Id_lien</text>""" % {'x': -105+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -105+x, 'y0': 11+y, 'x1': -62+x, 'y1': 11+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Lien vers les pages d’avis de la CT</text>""" % {'x': -105+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity AvisServiceMédicalRendu -->"""
(x,y) = (cx[u"AvisServiceMédicalRendu"],cy[u"AvisServiceMédicalRendu"])
lines += u"""\n<g id="entity-AvisServiceMédicalRendu">""" % {}
lines += u"""\n	<g id="frame-AvisServiceMédicalRendu">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="320" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -160+x, 'y': -68+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="320" height="111" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -160+x, 'y': -43.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="320" height="136" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -160+x, 'y': -68+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -160+x, 'y0': -43+y, 'x1': 160+x, 'y1': -43+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">AvisServiceMédicalRendu</text>""" % {'x': -77+x, 'y': -50.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Identifiant</text>""" % {'x': -155+x, 'y': -25.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -155+x, 'y0': -23+y, 'x1': -92+x, 'y1': -23+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code de dossier HAS</text>""" % {'x': -155+x, 'y': -8.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Motif d’évaluation</text>""" % {'x': -155+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Date de l’avis de la Commission de la transparence</text>""" % {'x': -155+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Valeur du SMR</text>""" % {'x': -155+x, 'y': 42.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Libelle du SMR</text>""" % {'x': -155+x, 'y': 59.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Composition -->"""
(x,y) = (cx[u"Composition"],cy[u"Composition"])
lines += u"""\n<g id="entity-Composition">""" % {}
lines += u"""\n	<g id="frame-Composition">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="262" height="25" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -131+x, 'y': -85+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="262" height="145" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -131+x, 'y': -60.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="262" height="170" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="2"/>""" % {'x': -131+x, 'y': -85+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -131+x, 'y0': -60+y, 'x1': 131+x, 'y1': -60+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Composition</text>""" % {'x': -38+x, 'y': -67.3+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code de la substance</text>""" % {'x': -126+x, 'y': -42.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -126+x, 'y0': -40+y, 'x1': 4+x, 'y1': -40+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Code CIS</text>""" % {'x': -126+x, 'y': -25.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Désignation de l'élément pharmaceutique</text>""" % {'x': -126+x, 'y': -8.3+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Dénomination de la substance</text>""" % {'x': -126+x, 'y': 8.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Dosage de la substance</text>""" % {'x': -126+x, 'y': 25.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Référence de ce dosage</text>""" % {'x': -126+x, 'y': 42.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Nature du composant</text>""" % {'x': -126+x, 'y': 59.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Verdana" font-size="12">Numéro de liaison SA/FT</text>""" % {'x': -126+x, 'y': 76.8+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}
lines += u'\n</svg>'

with codecs.open("Fichierspecialites.svg", "w", "utf8") as f:
    f.write(lines)
safe_print_for_PHP(u'Fichier de sortie "Fichierspecialites.svg" généré avec succès.')