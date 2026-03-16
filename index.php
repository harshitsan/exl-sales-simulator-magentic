<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EXL Pitch Simulator</title>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --bg: #f5f5f3;
      --sf: #ffffff;
      --s2: #f0eeeb;
      --s3: #e8e5e0;
      --br: #e0ddd8;
      --bb: #c8c4bc;
      --bh: #a09890;
      --acc: #fb4e0b;
      --acd: rgba(251, 78, 11, 0.08);
      --acb: rgba(251, 78, 11, 0.2);
      --ok: #16a34a;
      --okd: rgba(22, 163, 74, 0.08);
      --okb: rgba(22, 163, 74, 0.2);
      --r: #dc2626;
      --rd: rgba(220, 38, 38, 0.08);
      --rb: rgba(220, 38, 38, 0.18);
      --amber: #d97706;
      --ambd: rgba(217, 119, 6, 0.08);
      --tx: #1a1a18;
      --tm: #5a5650;
      --td: #a09890;
      --rad: 12px;
      --rads: 8px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      -webkit-font-smoothing: antialiased
    }

    html,
    body {
      height: 100%;
      background: var(--bg);
      color: var(--tx);
      font-family: 'Plus Jakarta Sans', sans-serif;
      overflow-x: hidden
    }

    .scr {
      display: none;
      min-height: 100vh;
      flex-direction: column;
      position: relative
    }

    .scr.on {
      display: flex;
      animation: fu .28s ease
    }

    @keyframes fu {
      from {
        opacity: 0;
        transform: translateY(6px)
      }

      to {
        opacity: 1;
        transform: none
      }
    }

    /* ── TOPBAR ── */
    .tb {
      height: 54px;
      background: #fff;
      border-bottom: 1px solid var(--br);
      display: flex;
      align-items: center;
      padding: 0 32px;
      gap: 14px;
      flex-shrink: 0;
      position: sticky;
      top: 0;
      z-index: 50
    }

    .logo {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 13px;
      color: var(--acc);
      letter-spacing: .12em;
      display: flex;
      align-items: center;
      gap: 9px
    }

    .ld {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--acc);
      animation: pk 2s infinite
    }

    @keyframes pk {

      0%,
      100% {
        opacity: 1
      }

      50% {
        opacity: .3
      }
    }

    .ml {
      margin-left: auto
    }

    .uc {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 5px 14px;
      border: 1px solid var(--br);
      border-radius: 99px;
      font-size: 13px;
      color: var(--tm)
    }

    .uav {
      width: 26px;
      height: 26px;
      background: var(--acc);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 9px;
      font-weight: 700;
      color: #fff;
      overflow: hidden
    }

    .uav img {
      width: 100%;
      height: 100%;
      object-fit: cover
    }

    .pbar {
      height: 3px;
      background: var(--br);
      flex-shrink: 0
    }

    .pb {
      height: 100%;
      background: var(--acc);
      transition: width .6s;
      border-radius: 0 2px 2px 0
    }

    /* ── CONTENT WRAPPER — 80% width ── */
    .w80 {
      width: 80%;
      margin: 0 auto
    }

    .ctr {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center;
      flex: 1;
      padding: 64px 0;
      width: 80%;
      margin: 0 auto
    }

    .ctr.centered {
      align-items: center;
      text-align: center
    }

    h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 42px;
      line-height: 1.08;
      letter-spacing: -.02em;
      color: var(--tx)
    }

    h2 {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 30px;
      line-height: 1.15;
      color: var(--tx)
    }

    h3 {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 20px;
      color: var(--tx)
    }

    .sub {
      font-size: 17px;
      color: var(--tm);
      line-height: 1.65
    }

    .card {
      background: var(--sf);
      border: 1px solid var(--br);
      border-radius: var(--rad);
      padding: 24px
    }

    .div {
      height: 1px;
      background: var(--br);
      margin: 20px 0
    }

    /* ── BUTTONS ── */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 13px 28px;
      border-radius: var(--rads);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      transition: all .16s;
      white-space: nowrap
    }

    .bp {
      background: var(--acc);
      color: #fff
    }

    .bp:hover {
      background: #e04008;
      transform: translateY(-1px)
    }

    .bs {
      background: #fff;
      color: var(--tx);
      border: 1px solid var(--bb)
    }

    .bs:hover {
      border-color: var(--acc);
      color: var(--acc)
    }

    .bd {
      background: var(--rd);
      color: var(--r);
      border: 1px solid var(--rb)
    }

    .big {
      padding: 16px 48px;
      font-size: 17px;
      border-radius: 99px
    }

    /* ── TAGS ── */
    .tag {
      display: inline-block;
      font-size: 11px;
      font-family: 'DM Mono', monospace;
      padding: 4px 10px;
      border-radius: 5px;
      letter-spacing: .04em
    }

    .ta {
      background: var(--acd);
      color: var(--acc);
      border: 1px solid var(--acb)
    }

    .tok {
      background: var(--okd);
      color: var(--ok);
      border: 1px solid var(--okb)
    }

    .tr {
      background: var(--rd);
      color: var(--r);
      border: 1px solid var(--rb)
    }

    .td2 {
      background: var(--s2);
      color: var(--tm);
      border: 1px solid var(--br)
    }

    .tw {
      background: var(--ambd);
      color: var(--amber);
      border: 1px solid rgba(217, 119, 6, .22)
    }

    /* ══════════ S1 LOGIN ══════════ */
    .login-split {
      display: grid;
      grid-template-columns: 1fr 1fr;
      flex: 1;
      min-height: 0
    }

    .login-left {
      background: var(--acc);
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 64px 56px;
      position: relative;
      overflow: hidden
    }

    .login-left::before {
      content: '';
      position: absolute;
      top: -80px;
      right: -80px;
      width: 360px;
      height: 360px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .06)
    }

    .login-left::after {
      content: '';
      position: absolute;
      bottom: -60px;
      left: -40px;
      width: 240px;
      height: 240px;
      border-radius: 50%;
      background: rgba(0, 0, 0, .08)
    }

    .login-hero-text {
      position: relative;
      z-index: 1
    }

    .login-right {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 64px 56px;
      background: #fff
    }

    .lcard {
      display: flex;
      flex-direction: column;
      gap: 20px;
      max-width: 380px
    }

    .flbl {
      font-size: 13px;
      font-weight: 600;
      color: var(--tx);
      margin-bottom: 6px
    }

    .finp {
      background: var(--s2);
      border: 1px solid var(--bb);
      border-radius: var(--rads);
      padding: 13px 16px;
      color: var(--tx);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 16px;
      outline: none;
      width: 100%;
      transition: border-color .18s
    }

    .finp:focus {
      border-color: var(--acc)
    }

    .finp::placeholder {
      color: var(--td)
    }

    /* ══════════ S2 IMU ══════════ */
    .imu-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      width: 100%
    }

    .imu-c {
      background: var(--sf);
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      padding: 22px 20px;
      cursor: pointer;
      transition: all .18s;
      display: flex;
      align-items: center;
      gap: 16px;
      text-align: left
    }

    .imu-c:hover:not(.lk),
    .imu-c.sel {
      border-color: var(--acc);
      background: var(--acd)
    }

    .imu-c.lk {
      opacity: .45;
      cursor: not-allowed
    }

    .imu-ic {
      width: 46px;
      height: 46px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      flex-shrink: 0;
      background: var(--s2)
    }

    .imu-nm {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 16px;
      margin-bottom: 3px
    }

    .imu-sb {
      font-size: 13px;
      color: var(--tm)
    }

    /* ══════════ S3 PHILOSOPHY ══════════ */
    .phil-split {
      display: grid;
      grid-template-columns: 1fr 1fr;
      flex: 1
    }

    .phil-img {
      background: #1a1a18;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative
    }

    .phil-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: .85
    }

    .phil-img-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to right, rgba(26, 26, 24, .5) 0%, transparent 60%)
    }

    .phil-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 72px 64px;
      gap: 28px;
      background: #fff
    }

    .phil-q {
      font-family: 'Syne', sans-serif;
      font-size: 28px;
      font-weight: 800;
      line-height: 1.35;
      color: var(--tx)
    }

    .phil-pts {
      display: flex;
      flex-direction: column;
      gap: 12px
    }

    .phil-pt {
      display: flex;
      gap: 12px;
      align-items: flex-start;
      font-size: 16px;
      color: var(--tm);
      line-height: 1.65
    }

    .phil-d {
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: var(--acc);
      flex-shrink: 0;
      margin-top: 9px
    }

    /* ══════════ S4 PILLARS ══════════ */
    .pgrid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      width: 100%;
      margin: 28px 0
    }

    .pc {
      background: var(--sf);
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      padding: 22px 24px;
      opacity: 0;
      transform: translateY(12px);
      transition: opacity .4s, transform .4s
    }

    .pc.on {
      opacity: 1;
      transform: none
    }

    .pc-num {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td);
      margin-bottom: 8px;
      letter-spacing: .1em
    }

    .pc-txt {
      font-size: 16px;
      font-weight: 600;
      color: var(--tx);
      line-height: 1.5
    }

    .sbw {
      opacity: 0;
      transition: opacity .4s;
      pointer-events: none
    }

    .sbw.on {
      opacity: 1;
      pointer-events: all
    }

    /* ══════════ S5 TUTORIAL OVERLAY ══════════ */
    .tut-overlay {
      position: fixed;
      inset: 0;
      z-index: 900;
      pointer-events: none;
      visibility: hidden
    }

    .tut-overlay.on {
      pointer-events: all;
      visibility: visible
    }

    .tut-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(26, 26, 24, .72)
    }

    .tut-spotlight {
      position: absolute;
      border-radius: 10px;
      box-shadow: 0 0 0 9999px rgba(26, 26, 24, .72), 0 0 0 2px var(--acc);
      transition: all .4s cubic-bezier(.4, 0, .2, 1);
      z-index: 901;
      pointer-events: none
    }

    .tut-card {
      position: absolute;
      background: #fff;
      border: 1px solid var(--br);
      border-radius: var(--rad);
      padding: 22px 24px;
      max-width: 300px;
      z-index: 902;
      box-shadow: 0 20px 48px rgba(0, 0, 0, .18);
      animation: fu .28s ease
    }

    .tut-step {
      font-size: 11px;
      font-family: 'DM Mono', monospace;
      color: var(--acc);
      margin-bottom: 8px;
      letter-spacing: .08em
    }

    .tut-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 18px;
      margin-bottom: 7px;
      color: var(--tx)
    }

    .tut-body {
      font-size: 14px;
      color: var(--tm);
      line-height: 1.6;
      margin-bottom: 16px
    }

    .tut-dots {
      display: flex;
      gap: 5px;
      margin-bottom: 12px
    }

    .tut-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--br)
    }

    .tut-dot.on {
      background: var(--acc)
    }

    /* ══════════ S6 LEAD (LinkedIn card) ══════════ */
    .li-card {
      background: var(--sf);
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      width: 100%;
      max-width: 680px;
      overflow: hidden;
      box-shadow: 0 2px 16px rgba(0, 0, 0, .06)
    }

    .li-banner {
      height: 88px;
      background: linear-gradient(135deg, #1a1a18 0%, #3a3530 100%);
      position: relative
    }

    .li-av-wrap {
      position: absolute;
      bottom: -40px;
      left: 28px
    }

    .li-av {
      width: 84px;
      height: 84px;
      border-radius: 50%;
      border: 4px solid #fff;
      background: var(--s2);
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 26px;
      color: var(--tm)
    }

    .li-av img {
      width: 100%;
      height: 100%;
      object-fit: cover
    }

    .li-logo {
      position: absolute;
      bottom: -28px;
      right: 28px;
      width: 54px;
      height: 54px;
      background: #fff;
      border: 2px solid var(--br);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .08)
    }

    .li-body {
      padding: 50px 28px 24px
    }

    .li-name {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 22px;
      margin-bottom: 2px;
      color: var(--tx)
    }

    .li-role {
      font-size: 14px;
      color: var(--tm);
      margin-bottom: 14px
    }

    .li-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-bottom: 16px
    }

    .hgrid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px
    }

    .hcard {
      background: var(--s2);
      border: 1.5px dashed var(--bb);
      border-radius: var(--rads);
      padding: 12px 14px;
      display: flex;
      gap: 10px;
      align-items: center
    }

    .hcard-lbl {
      font-size: 13px;
      color: var(--td);
      font-style: italic
    }

    .hcard.found {
      border-color: var(--okb);
      background: var(--okd);
      border-style: solid
    }

    .hcard.found .hcard-lbl {
      color: var(--tx);
      font-style: normal;
      font-weight: 600
    }

    /* ══════════ S7 CALL ══════════ */
    .call-wrap {
      display: grid;
      grid-template-columns: 240px 1fr 220px;
      flex: 1;
      min-height: 0;
      overflow: hidden
    }

    .cpanel {
      background: #fff;
      border-right: 1px solid var(--br);
      display: flex;
      flex-direction: column;
      overflow-y: auto
    }

    .cpanel.right {
      border-right: none;
      border-left: 1px solid var(--br)
    }

    .phdr {
      padding: 12px 16px;
      border-bottom: 1px solid var(--br);
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td);
      letter-spacing: .12em;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
      text-transform: uppercase
    }

    /* trust */
    .tsec {
      padding: 16px
    }

    .tnum {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 44px;
      line-height: 1;
      transition: color .3s;
      color: var(--tx)
    }

    .tnum.pos {
      color: var(--ok)
    }

    .tnum.neg {
      color: var(--r)
    }

    .tnum.neu {
      color: var(--amber)
    }

    .ttrack {
      height: 8px;
      background: var(--s2);
      border-radius: 4px;
      overflow: hidden;
      margin: 10px 0 5px
    }

    .tfill {
      height: 100%;
      border-radius: 4px;
      transition: width .55s cubic-bezier(.34, 1.56, .64, 1), background .3s
    }

    .tlbls {
      display: flex;
      justify-content: space-between;
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td)
    }

    /* insights */
    .isec {
      padding: 12px 16px;
      flex: 1
    }

    .ii {
      display: flex;
      gap: 10px;
      align-items: flex-start;
      padding: 9px 0;
      border-bottom: 1px solid var(--br);
      font-size: 13px;
      color: var(--tm);
      line-height: 1.45
    }

    .ii:last-child {
      border-bottom: none
    }

    .idot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      flex-shrink: 0;
      margin-top: 3px;
      transition: all .3s
    }

    .idot.fnd {
      background: var(--ok)
    }

    .idot.hid {
      background: var(--br);
      border: 1.5px solid var(--bb)
    }

    .itext.fnd {
      color: var(--tx);
      font-weight: 600
    }

    /* call center */
    .ccenter {
      display: flex;
      flex-direction: column;
      flex: 1;
      min-height: 0;
      background: var(--bg)
    }

    /* persona strip */
    .persona-area {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 20px;
      border-bottom: 1px solid var(--br);
      background: #fff;
      flex-shrink: 0
    }

    .pring {
      position: relative;
      width: 56px;
      height: 56px;
      flex-shrink: 0
    }

    .pr1,
    .pr2 {
      position: absolute;
      border-radius: 50%;
      border: 1.5px solid rgba(251, 78, 11, .12);
      transition: .3s
    }

    .pr1 {
      inset: -7px
    }

    .pr2 {
      inset: -14px
    }

    .pr1.sp {
      border-color: rgba(251, 78, 11, .45);
      animation: rp .9s infinite
    }

    .pr2.sp {
      border-color: rgba(251, 78, 11, .2);
      animation: rp .9s .15s infinite
    }

    @keyframes rp {

      0%,
      100% {
        transform: scale(1)
      }

      50% {
        transform: scale(1.07)
      }
    }

    .pav {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: var(--s2);
      border: 2px solid var(--br);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 16px;
      color: var(--tm);
      position: relative;
      z-index: 1;
      overflow: hidden
    }

    .pav img {
      width: 100%;
      height: 100%;
      object-fit: cover
    }

    .pbadge {
      background: var(--acc);
      color: #fff;
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      padding: 2px 9px;
      border-radius: 99px;
      opacity: 0;
      transition: opacity .25s
    }

    .pbadge.on {
      opacity: 1
    }

    .persona-info {
      flex: 1
    }

    /* transcript */
    .txbox {
      flex: 1;
      overflow-y: auto;
      padding: 16px 20px;
      display: flex;
      flex-direction: column;
      gap: 2px;
      background: var(--bg)
    }

    .txbox::-webkit-scrollbar {
      width: 2px
    }

    .txbox::-webkit-scrollbar-thumb {
      background: var(--bb);
      border-radius: 1px
    }

    .txl {
      font-size: 15px;
      line-height: 1.7;
      padding: 7px 0;
      border-bottom: 1px solid var(--br)
    }

    .txl:last-child {
      border-bottom: none
    }

    .txl.cli {
      color: var(--tx)
    }

    .txl.usr {
      color: var(--acc);
      padding-left: 14px;
      border-left: 2px solid var(--acb)
    }

    .txlbl {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td);
      margin-bottom: 2px;
      letter-spacing: .06em
    }

    /* action area */
    .aarea {
      padding: 14px 18px;
      border-top: 1px solid var(--br);
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      gap: 9px;
      background: #fff
    }

    .meet-banner {
      display: none;
      background: var(--okd);
      border: 1px solid var(--okb);
      border-radius: var(--rads);
      padding: 10px 14px;
      font-size: 14px;
      color: var(--ok);
      gap: 10px;
      align-items: center;
      font-weight: 600;
      animation: fu .3s
    }

    .meet-banner.on {
      display: flex
    }

    .frames {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 7px
    }

    .fbtn {
      padding: 11px 13px;
      background: var(--s2);
      border: 1.5px solid var(--br);
      border-radius: var(--rads);
      cursor: pointer;
      transition: all .16s;
      text-align: left;
      display: flex;
      flex-direction: column;
      gap: 3px
    }

    .fbtn:hover {
      border-color: var(--acc);
      background: var(--acd)
    }

    .fbtn.used {
      opacity: .38
    }

    .fbtn-nm {
      font-size: 14px;
      font-weight: 600;
      color: var(--tx)
    }

    .fbtn-ds {
      font-size: 12px;
      color: var(--tm)
    }

    .meet-btn {
      width: 100%;
      padding: 12px 16px;
      background: var(--s2);
      border: 1.5px solid var(--bb);
      border-radius: var(--rads);
      cursor: pointer;
      transition: all .2s;
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      color: var(--tm);
      font-weight: 600
    }

    .meet-btn:hover {
      border-color: var(--bh)
    }

    .meet-btn.unlocked {
      border-color: var(--ok);
      background: var(--okd);
      color: var(--ok)
    }

    .lock {
      margin-left: auto;
      font-size: 13px
    }

    /* coach panel */
    .cbox {
      margin: 10px 12px;
      background: var(--ambd);
      border: 1px solid rgba(217, 119, 6, .2);
      border-radius: var(--rads);
      padding: 12px 14px;
      font-size: 14px;
      color: var(--tm);
      line-height: 1.6
    }

    .cbox strong {
      color: var(--amber)
    }

    .scrow {
      display: flex;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid var(--br);
      font-size: 13px
    }

    .scrow:last-child {
      border-bottom: none
    }

    .sc-lbl {
      color: var(--tm);
      flex: 1
    }

    .sc-bar {
      width: 54px;
      height: 3px;
      background: var(--s2);
      border-radius: 2px;
      margin: 0 8px;
      overflow: hidden;
      flex-shrink: 0
    }

    .sc-fill {
      height: 100%;
      border-radius: 2px;
      background: var(--acc);
      transition: width .5s
    }

    .sc-pct {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--tm);
      min-width: 28px;
      text-align: right
    }

    /* ══════════ S8 FAIL ══════════ */
    .fail-box {
      background: #fff;
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      overflow: hidden;
      width: 100%
    }

    .fail-top {
      background: var(--r);
      padding: 28px 32px;
      display: flex;
      align-items: center;
      gap: 18px
    }

    .fail-body {
      padding: 24px 32px;
      display: flex;
      flex-direction: column;
      gap: 14px
    }

    .fbi {
      display: flex;
      gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid var(--br);
      font-size: 15px;
      color: var(--tm);
      line-height: 1.55;
      align-items: flex-start
    }

    .fbi:last-child {
      border-bottom: none
    }

    /* ══════════ S9 MEETING ══════════ */
    .meeting-split {
      display: grid;
      grid-template-columns: 1fr 1fr;
      flex: 1;
      min-height: 0
    }

    .meeting-left {
      background: var(--acc);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 64px 56px;
      gap: 24px;
      position: relative;
      overflow: hidden
    }

    .meeting-left::before {
      content: '';
      position: absolute;
      top: -60px;
      right: -60px;
      width: 280px;
      height: 280px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .08)
    }

    .meeting-right {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 64px 56px;
      gap: 24px;
      background: #fff
    }

    .ins-row {
      display: flex;
      gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid var(--br);
      font-size: 15px;
      color: var(--tm);
      line-height: 1.5;
      align-items: flex-start
    }

    .ins-row:last-child {
      border-bottom: none
    }

    .ins-row.fnd {
      color: var(--tx)
    }

    .ins-ic {
      font-size: 17px;
      flex-shrink: 0;
      margin-top: 1px
    }

    /* ══════════ S10 SOLUTION ══════════ */
    .sol-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      width: 100%
    }

    .sol-c {
      background: #fff;
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      padding: 24px;
      cursor: pointer;
      transition: all .18s;
      display: flex;
      flex-direction: column;
      gap: 10px
    }

    .sol-c:hover {
      border-color: var(--acc);
      transform: translateY(-2px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, .08)
    }

    .sol-c.wrong {
      border-color: var(--r) !important;
      background: var(--rd) !important;
      animation: sh .4s
    }

    .sol-c.ok {
      border-color: var(--ok) !important;
      background: var(--okd) !important;
      pointer-events: none
    }

    @keyframes sh {

      0%,
      100% {
        transform: translateX(0)
      }

      25% {
        transform: translateX(-5px)
      }

      75% {
        transform: translateX(5px)
      }
    }

    .sol-ic {
      font-size: 28px
    }

    .sol-nm {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 16px;
      color: var(--tx)
    }

    .sol-ds {
      font-size: 14px;
      color: var(--tm);
      line-height: 1.5
    }

    /* ══════════ S11 DECK ══════════ */
    .deck-wrap {
      display: grid;
      grid-template-columns: 1fr 300px;
      flex: 1;
      min-height: 0
    }

    .deck-main {
      overflow-y: auto;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      background: var(--bg)
    }

    .ppt-slide {
      background: #fff;
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      overflow: hidden;
      transition: all .3s
    }

    .ppt-slide.gap {
      border-color: rgba(220, 38, 38, .3);
      border-style: dashed;
      background: var(--rd)
    }

    .ppt-slide.new-slide {
      border-color: var(--ok);
      background: var(--okd);
      animation: sli .4s
    }

    @keyframes sli {
      from {
        opacity: 0;
        transform: translateX(-12px)
      }

      to {
        opacity: 1;
        transform: none
      }
    }

    .ppt-top {
      background: var(--s2);
      padding: 12px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid var(--br)
    }

    .ppt-num {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td);
      min-width: 18px
    }

    .ppt-ic {
      font-size: 17px
    }

    .ppt-t {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 14px;
      flex: 1;
      color: var(--tx)
    }

    .ppt-body {
      padding: 10px 18px 13px;
      font-size: 13px;
      color: var(--tm)
    }

    .chg-panel {
      background: #fff;
      border-left: 1px solid var(--br);
      overflow-y: auto;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px
    }

    .chg-intro {
      background: var(--s2);
      border: 1px solid var(--br);
      border-radius: var(--rads);
      padding: 14px 16px;
      font-size: 14px;
      color: var(--tm);
      line-height: 1.6
    }

    .chg-intro strong {
      color: var(--tx)
    }

    .chg-btn {
      background: var(--s2);
      border: 1.5px solid var(--br);
      border-radius: var(--rads);
      padding: 12px 14px;
      cursor: pointer;
      transition: all .16s;
      font-size: 14px;
      color: var(--tm);
      text-align: left;
      line-height: 1.5;
      display: flex;
      gap: 10px;
      align-items: flex-start;
      width: 100%
    }

    .chg-btn:hover {
      border-color: var(--acc);
      color: var(--tx)
    }

    .chg-btn.wrong {
      border-color: var(--r);
      background: var(--rd);
      color: var(--r);
      animation: sh .4s
    }

    .chg-btn.ok {
      border-color: var(--ok);
      background: var(--okd);
      color: var(--ok);
      pointer-events: none
    }

    .chg-n {
      font-family: 'DM Mono', monospace;
      font-size: 10px;
      color: var(--td);
      flex-shrink: 0;
      padding-top: 2px
    }

    /* ══════════ S12 DECK DONE ══════════ */
    .deck-done-split {
      display: grid;
      grid-template-columns: 1fr 1fr;
      flex: 1;
      min-height: 0
    }

    .deck-done-left {
      background: #1a1a18;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 64px 56px;
      gap: 24px;
      position: relative
    }

    .deck-done-right {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 64px 56px;
      gap: 20px;
      background: #fff
    }

    /* ══════════ S13 PITCH ══════════ */
    .pitch-wrap {
      display: grid;
      grid-template-columns: 1fr 260px;
      flex: 1;
      min-height: 0;
      overflow: hidden
    }

    .pmain {
      overflow-y: auto;
      overflow-x: hidden;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      background: var(--bg);
      min-height: 0
    }

    .avrow {
      display: flex;
      gap: 12px;
      justify-content: center
    }

    .stk {
      background: #fff;
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      padding: 16px 12px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      flex: 1;
      max-width: 196px;
      transition: all .22s
    }

    .stk.spe {
      border-color: var(--acc);
      background: var(--acd);
      box-shadow: 0 0 0 3px var(--acb)
    }

    .stk.obj {
      border-color: var(--amber);
      background: var(--ambd)
    }

    .stk-av {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      border: 2.5px solid;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 20px;
      flex-shrink: 0;
      background: var(--s2)
    }

    .stk-av img {
      width: 100%;
      height: 100%;
      object-fit: cover
    }

    .stk-nm {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 13px;
      color: var(--tx)
    }

    .stk-rl {
      font-size: 11px;
      color: var(--tm)
    }

    .stk-bar-wrap {
      width: 100%;
      background: var(--s2);
      height: 5px;
      border-radius: 3px;
      overflow: hidden
    }

    .stk-bar {
      height: 100%;
      border-radius: 3px;
      transition: width .55s cubic-bezier(.34, 1.56, .64, 1), background .3s
    }

    .stk-sc {
      font-family: 'DM Mono', monospace;
      font-size: 12px;
      color: var(--tm)
    }

    .pslide {
      background: #fff;
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      overflow: hidden
    }

    .psl-h {
      background: var(--s2);
      padding: 16px 22px;
      border-bottom: 1px solid var(--br)
    }

    .psl-meta {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td);
      margin-bottom: 5px;
      letter-spacing: .06em
    }

    .psl-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 18px;
      margin-bottom: 3px;
      color: var(--tx)
    }

    .psl-sub {
      font-size: 14px;
      color: var(--tm)
    }

    .psl-body {
      padding: 16px 22px;
      display: flex;
      flex-direction: column;
      gap: 8px
    }

    .psl-pt {
      display: flex;
      gap: 10px;
      font-size: 14px;
      color: var(--tm);
      line-height: 1.5;
      align-items: flex-start
    }

    .psl-pt::before {
      content: '—';
      color: var(--acc);
      flex-shrink: 0;
      font-weight: 700
    }

    .psl-nav {
      padding: 12px 22px;
      display: flex;
      gap: 8px;
      border-top: 1px solid var(--br)
    }

    .vcall-area {
      background: #fff;
      border: 1.5px solid var(--br);
      border-radius: var(--rad);
      overflow: hidden
    }

    .vcall-hdr {
      padding: 10px 18px 9px;
      border-bottom: 1px solid var(--br);
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td);
      letter-spacing: .1em;
      display: flex;
      align-items: center;
      gap: 7px;
      text-transform: uppercase
    }

    .vcall-tx {
      padding: 14px 18px;
      max-height: 130px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 2px;
      background: var(--bg)
    }

    .vtxl {
      font-size: 14px;
      line-height: 1.65;
      padding: 4px 0;
      border-bottom: 1px solid var(--br)
    }

    .vtxl:last-child {
      border-bottom: none
    }

    .vtxl.cli {
      color: var(--tx)
    }

    .vtxl.usr {
      color: var(--acc);
      padding-left: 12px;
      border-left: 2px solid var(--acb)
    }

    .vtxlbl {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--td);
      margin-bottom: 2px;
      letter-spacing: .06em
    }

    .vframes {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 6px;
      padding: 10px 18px;
      border-top: 1px solid var(--br);
      background: #fff
    }

    .vf {
      padding: 9px 12px;
      background: var(--s2);
      border: 1.5px solid var(--br);
      border-radius: var(--rads);
      cursor: pointer;
      font-size: 13px;
      color: var(--tm);
      font-weight: 600;
      transition: all .16s;
      text-align: left
    }

    .vf:hover {
      border-color: var(--acc);
      color: var(--tx);
      background: var(--acd)
    }

    .vf.used {
      opacity: .35
    }

    .obj-bub {
      background: #fff;
      border: 1.5px solid var(--amber);
      border-radius: var(--rad);
      padding: 16px 20px;
      font-size: 15px;
      color: var(--tx);
      line-height: 1.6;
      display: none;
      box-shadow: 0 2px 12px rgba(0, 0, 0, .08)
    }

    .obj-bub.on {
      display: block;
      animation: fu .3s
    }

    .obj-who {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--amber);
      margin-bottom: 7px;
      letter-spacing: .08em
    }

    .obj-opts {
      display: flex;
      flex-direction: column;
      gap: 7px;
      margin-top: 12px
    }

    .obj-opt {
      font-size: 14px;
      padding: 12px 16px;
      border-radius: var(--rads);
      background: var(--s2);
      border: 1.5px solid var(--br);
      color: var(--tm);
      cursor: pointer;
      transition: all .16s;
      text-align: left;
      line-height: 1.5
    }

    .obj-opt:hover {
      border-color: var(--acc);
      color: var(--tx)
    }

    .pright {
      background: #fff;
      border-left: 1px solid var(--br);
      overflow-y: auto;
      display: flex;
      flex-direction: column
    }

    .stk-mini {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 9px 12px;
      background: var(--s2);
      border-radius: var(--rads);
      border: 1px solid var(--br)
    }

    .stk-av-sm {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 10px;
      border: 2px solid;
      flex-shrink: 0;
      background: var(--s2)
    }

    .stk-av-sm img {
      width: 100%;
      height: 100%;
      object-fit: cover
    }

    /* ══════════ WIN / CERT ══════════ */
    .win-split {
      display: grid;
      grid-template-columns: 1fr 1fr;
      flex: 1;
      min-height: 0
    }

    .win-left {
      background: var(--acc);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 64px 56px;
      gap: 24px;
      position: relative;
      overflow: hidden
    }

    .win-left::before {
      content: '';
      position: absolute;
      bottom: -80px;
      right: -80px;
      width: 320px;
      height: 320px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .08)
    }

    .win-right {
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 64px 56px;
      gap: 24px
    }

    .rmet-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
      width: 100%
    }

    .rmet {
      background: var(--s2);
      border: 1px solid var(--br);
      border-radius: var(--rad);
      padding: 18px;
      text-align: center
    }

    .rmet-v {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 30px;
      line-height: 1;
      color: var(--tx)
    }

    .rmet-l {
      font-size: 11px;
      color: var(--td);
      margin-top: 5px;
      font-family: 'DM Mono', monospace;
      letter-spacing: .04em
    }

    .cert {
      background: #fff;
      border: 2px solid var(--br);
      border-radius: 16px;
      padding: 44px;
      max-width: 600px;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      text-align: center;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 32px rgba(0, 0, 0, .08)
    }

    .cert::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--acc)
    }

    .cert-badge {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      background: var(--acc);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 32px
    }

    .cert-sigs {
      display: flex;
      gap: 40px;
      margin-top: 6px
    }

    .cert-sig {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 5px
    }

    .cert-line {
      width: 110px;
      height: 1px;
      background: var(--bb)
    }

    .cert-lbl {
      font-size: 11px;
      color: var(--tm)
    }

    /* FLASH */
    .flash {
      position: fixed;
      inset: 0;
      z-index: 999;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 14px;
      pointer-events: none;
      opacity: 0;
      transition: opacity .22s
    }

    .flash.on {
      opacity: 1;
      pointer-events: all
    }

    .flash-bg {
      position: absolute;
      inset: 0;
      background: rgba(26, 26, 24, .82)
    }

    .flash-con {
      position: relative;
      z-index: 1;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 11px;
      max-width: 340px;
      padding: 0 20px
    }

    .flash-ic {
      font-size: 60px;
      animation: po .3s cubic-bezier(.34, 1.56, .64, 1)
    }

    @keyframes po {
      from {
        transform: scale(0)
      }

      to {
        transform: scale(1)
      }
    }

    .flash-title {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 24px;
      color: #fff
    }

    .flash-sub {
      font-size: 16px;
      color: rgba(255, 255, 255, .7);
      line-height: 1.6
    }

    ::-webkit-scrollbar {
      width: 3px;
      height: 3px
    }

    ::-webkit-scrollbar-track {
      background: transparent
    }

    ::-webkit-scrollbar-thumb {
      background: var(--bb);
      border-radius: 2px
    }
  </style>
</head>

<body>

  <!-- ════ S1 LOGIN ════ -->
  <div class="scr on" id="s-login">
    <div class="login-split" style="flex:1">
      <div class="login-left">
        <div class="login-hero-text">
          <div
            style="font-family:'DM Mono',monospace;font-size:11px;letter-spacing:.14em;color:rgba(255,255,255,.6);margin-bottom:16px">
            EXL PITCH SIMULATOR</div>
          <h1 style="color:#fff;font-size:44px;margin-bottom:16px">Practice the<br>consultative sale.</h1>
          <p style="font-size:17px;color:rgba(255,255,255,.75);line-height:1.65">Earn trust. Uncover pain. Close deals —
            before you walk into the room.</p>
        </div>
      </div>
      <div class="login-right">
        <div class="lcard">
          <div>
            <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:var(--tx);margin-bottom:6px">
              Sign in</div>
            <p style="font-size:15px;color:var(--tm)">Enter your details to get started.</p>
          </div>
          <div>
            <div class="flbl">Employee ID</div><input class="finp" id="emp-id" placeholder="e.g. EXL-2024-7842"
              maxlength="20">
          </div>
          <div>
            <div class="flbl">Your Name</div><input class="finp" id="emp-name" placeholder="Full name"
              onkeydown="if(event.key==='Enter')doLogin()">
          </div>
          <button class="btn bp" style="width:100%;padding:15px;font-size:16px" onclick="doLogin()">Continue →</button>
          <p id="lerr" style="font-size:13px;color:var(--r);display:none">Please fill in both fields.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ════ S2 IMU ════ -->
  <div class="scr" id="s-imu">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
      <div class="ml">
        <div class="uc">
          <div class="uav" id="ua1">RS</div><span id="un1">Rahul S.</span>
        </div>
      </div>
    </div>
    <div class="ctr" style="gap:32px">
      <div>
        <h2>Which vertical do you sell into?</h2>
        <p class="sub" style="margin-top:8px">Scenarios and personas are tailored to your vertical.</p>
      </div>
      <div class="imu-grid">
        <div class="imu-c" onclick="pickIMU(this)">
          <div class="imu-ic" style="background:var(--acd)">🏛️</div>
          <div>
            <div class="imu-nm">Insurance</div>
            <div class="imu-sb">L&A · P&C · IFRS 17</div><span class="tag ta"
              style="margin-top:8px;display:inline-block">Available now</span>
          </div>
        </div>
        <div class="imu-c lk">
          <div class="imu-ic">❤️</div>
          <div>
            <div class="imu-nm">Healthcare</div>
            <div class="imu-sb">Payer · Provider · RCM</div><span class="tag td2"
              style="margin-top:8px;display:inline-block">Coming soon</span>
          </div>
        </div>
        <div class="imu-c lk">
          <div class="imu-ic">🏦</div>
          <div>
            <div class="imu-nm">Banking & Capital Markets</div>
            <div class="imu-sb">Retail · Compliance · Risk</div><span class="tag td2"
              style="margin-top:8px;display:inline-block">Coming soon</span>
          </div>
        </div>
        <div class="imu-c lk">
          <div class="imu-ic">⚙️</div>
          <div>
            <div class="imu-nm">Diversified Industries</div>
            <div class="imu-sb">Manufacturing · Logistics</div><span class="tag td2"
              style="margin-top:8px;display:inline-block">Coming soon</span>
          </div>
        </div>
      </div>
      <button class="btn bp big" id="imu-go" style="display:none" onclick="go('s-philosophy')">Enter Insurance Track
        →</button>
    </div>
  </div>

  <!-- ════ S3 PHILOSOPHY ════ -->
  <div class="scr" id="s-philosophy">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div><span style="font-size:13px;color:var(--tm)">Insurance · Level 1</span>
      <div class="ml">
        <div class="uc">
          <div class="uav" id="ua2">RS</div><span id="un2">Rahul S.</span>
        </div>
      </div>
    </div>
    <div class="phil-split" style="flex:1">
      <div class="phil-img">
        <img src="https://images.unsplash.com/photo-1560472355-536de3962603?w=800&q=80" alt="Corporate meeting"
          onerror="this.parentNode.style.background='#1a1a18'">
        <div class="phil-img-overlay"></div>
      </div>
      <div class="phil-content">
        <span class="tag ta">LEVEL 1 · DISCOVERY</span>
        <div class="phil-q">"High-ticket solutions aren't sold — they're earned through trust."</div>
        <div class="phil-pts">
          <div class="phil-pt">
            <div class="phil-d"></div>Your client doesn't need a vendor. They need a trusted advisor.
          </div>
          <div class="phil-pt">
            <div class="phil-d"></div>Ask the questions they haven't thought of. Solve what they're afraid to voice.
          </div>
        </div>
        <button class="btn bp big" style="align-self:flex-start" onclick="go('s-pillars')">See what you'll be tested on
          →</button>
      </div>
    </div>
  </div>

  <!-- ════ S4 PILLARS ════ -->
  <div class="scr" id="s-pillars">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
      <div class="ml">
        <div class="uc">
          <div class="uav">RS</div>
        </div>
      </div>
    </div>
    <div class="ctr" style="gap:0;padding:64px 0">
      <span class="tag ta" style="margin-bottom:14px">DISCOVERY PILLARS</span>
      <h2 style="margin-bottom:8px">In this call, you need to…</h2>
      <p class="sub" style="margin-bottom:0">Do these five things — and the trust takes care of itself.</p>
      <div class="pgrid" id="pgrid">
        <div class="pc">
          <div class="pc-num">01</div>
          <div class="pc-txt">Start strong. Say who you are, EXL, and why you're calling Marcus specifically.</div>
        </div>
        <div class="pc">
          <div class="pc-num">02</div>
          <div class="pc-txt">Listen, then reflect. Repeat Marcus's exact words back to him.</div>
        </div>
        <div class="pc">
          <div class="pc-num">03</div>
          <div class="pc-txt">Dig one level deeper. After he answers, ask the follow-up — not the pitch.</div>
        </div>
        <div class="pc">
          <div class="pc-num">04</div>
          <div class="pc-txt">Make the cost of doing nothing real. Help him feel what staying put costs.</div>
        </div>
        <div class="pc" style="grid-column:1/-1">
          <div class="pc-num">05</div>
          <div class="pc-txt">Don't pitch yet. Your only job today is to earn the right to a meeting.</div>
        </div>
      </div>
      <div class="sbw" id="sbw"><button class="btn bp big" onclick="go('s-lead')">Meet your lead →</button></div>
    </div>
  </div>

  <!-- ════ S6 LEAD ════ -->
  <div class="scr" id="s-lead">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div><span style="font-size:13px;color:var(--tm)">Level 1 · Discovery</span>
      <div class="ml">
        <div class="uc">
          <div class="uav">RS</div>
        </div>
      </div>
    </div>
    <div class="ctr" style="gap:24px;align-items:center;text-align:center">
      <div><span class="tag tw" style="margin-bottom:14px;display:inline-block">🎲 YOUR LEAD</span>
        <h2>Your discovery target</h2>
        <p class="sub" style="margin-top:6px;font-size:15px">The four locked cards must be uncovered on the call.</p>
      </div>
      <div class="li-card">
        <div class="li-banner"></div>
        <div class="li-av-wrap">
          <div class="li-av"><img src="https://i.pravatar.cc/84?img=57" alt="Marcus Chen"
              onerror="this.style.display='none'"></div>
        </div>
        <div class="li-logo">🏛️</div>
        <div class="li-body">
          <div class="li-name">Marcus Chen</div>
          <div class="li-role">Chief Operating Officer · Aethelgard Life Holdings · Singapore</div>
          <div class="li-tags">
            <span class="tag td2">Insurance · L&A</span>
            <span class="tag tw">3 Acquisitions · 24 months</span>
            <span class="tag td2">EU / APAC Operations</span>
            <span class="tag tr">Cost-to-Serve +15%</span>
          </div>
          <div style="height:1px;background:var(--br);margin:14px 0"></div>
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
            <div
              style="width:44px;height:44px;border-radius:9px;background:var(--s2);border:1px solid var(--br);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0">
              🏛️</div>
            <div>
              <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:var(--tx)">Aethelgard Life
              </div>
              <div style="font-size:13px;color:var(--tm)">Multi-market insurer · No big-bang replacements</div>
            </div>
          </div>
          <div
            style="font-size:11px;font-family:'DM Mono',monospace;color:var(--td);letter-spacing:.1em;margin-bottom:10px">
            🔒 UNCOVER ON THE CALL</div>
          <div class="hgrid" id="lead-hidden">
            <div class="hcard" id="lh0"><span style="font-size:16px">🔒</span><span class="hcard-lbl">Current
                Challenge</span></div>
            <div class="hcard" id="lh1"><span style="font-size:16px">🔒</span><span class="hcard-lbl">Where It
                Hurts</span></div>
            <div class="hcard" id="lh2"><span style="font-size:16px">🔒</span><span class="hcard-lbl">What They've
                Tried</span></div>
            <div class="hcard" id="lh3"><span style="font-size:16px">🔒</span><span
                class="hcard-lbl">Non-Negotiables</span></div>
          </div>
        </div>
      </div>
      <button class="btn bp big" onclick="startCallWithTutorial()">📞 Start Discovery Call →</button>
    </div>
  </div>

  <!-- ════ S7 CALL ════ -->
  <div class="scr" id="s-call" style="overflow:hidden;height:100vh">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
      <span style="font-size:13px;color:var(--tm)">Discovery Call · Marcus Chen, COO</span>
      <div class="ml" style="display:flex;gap:10px;align-items:center">
        <span id="ctimer" style="font-size:13px;color:var(--amber);font-family:'DM Mono',monospace">⏱ 00:00</span>
        <button class="btn bd" style="padding:6px 14px;font-size:13px" onclick="endCallEarly()">End Call</button>
      </div>
    </div>
    <div class="pbar">
      <div class="pb" id="cprog" style="width:25%"></div>
    </div>
    <div class="call-wrap" style="flex:1;min-height:0">
      <!-- LEFT -->
      <div class="cpanel" id="left-panel">
        <div class="phdr" id="ts-panel-hdr">Trust Score <span id="tnum" class="tnum neu">0</span></div>
        <div class="tsec">
          <div class="ttrack">
            <div class="tfill" id="tbar" style="width:50%;background:var(--amber)"></div>
          </div>
          <div class="tlbls"><span style="color:var(--r)">−100 fail</span><span>0</span><span
              style="color:var(--ok)">+100 close</span></div>
        </div>
        <div class="isec" id="insights-panel">
          <div
            style="font-size:10px;font-family:'DM Mono',monospace;color:var(--td);letter-spacing:.1em;margin-bottom:10px;text-transform:uppercase">
            Hidden Insights</div>
          <div class="ii" id="ii0">
            <div class="idot hid" id="id0"></div>
            <div class="itext" id="it0">Current Challenge</div>
          </div>
          <div class="ii" id="ii1">
            <div class="idot hid" id="id1"></div>
            <div class="itext" id="it1">Where It Hurts</div>
          </div>
          <div class="ii" id="ii2">
            <div class="idot hid" id="id2"></div>
            <div class="itext" id="it2">What They've Tried</div>
          </div>
          <div class="ii" id="ii3">
            <div class="idot hid" id="id3"></div>
            <div class="itext" id="it3">Non-Negotiables</div>
          </div>
        </div>
      </div>
      <!-- CENTER -->
      <div class="ccenter">
        <div class="persona-area" id="persona-area">
          <div class="pring">
            <div class="pr1" id="pr1"></div>
            <div class="pr2" id="pr2"></div>
            <div class="pav"><img src="https://i.pravatar.cc/56?img=57" alt="Marcus Chen"
                onerror="this.style.display='none'"></div>
          </div>
          <div class="persona-info">
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:16px;color:var(--tx)">Marcus Chen</div>
            <div style="font-size:13px;color:var(--tm)">COO · Aethelgard Life Holdings</div>
            <div class="pbadge on" id="pbadge" style="margin-top:5px;display:inline-block">listening…</div>
          </div>
          <div style="display:flex;flex-direction:column;gap:5px;min-width:120px" id="scores-strip">
            <div class="scrow"><span class="sc-lbl">Intro</span>
              <div class="sc-bar">
                <div class="sc-fill" id="sc0" style="width:0%"></div>
              </div><span class="sc-pct" id="scp0">0%</span>
            </div>
            <div class="scrow"><span class="sc-lbl">Mirror</span>
              <div class="sc-bar">
                <div class="sc-fill" id="sc1" style="width:0%"></div>
              </div><span class="sc-pct" id="scp1">0%</span>
            </div>
            <div class="scrow"><span class="sc-lbl">Curiosity</span>
              <div class="sc-bar">
                <div class="sc-fill" id="sc2" style="width:0%"></div>
              </div><span class="sc-pct" id="scp2">0%</span>
            </div>
            <div class="scrow"><span class="sc-lbl">Implication</span>
              <div class="sc-bar">
                <div class="sc-fill" id="sc3" style="width:0%"></div>
              </div><span class="sc-pct" id="scp3">0%</span>
            </div>
          </div>
        </div>
        <div class="txbox" id="txbox"></div>
        <div class="aarea">
          <div class="meet-banner" id="meet-banner">✓ Trust built — ask for a meeting now.</div>
          <div class="frames">
            <button class="fbtn" id="qf-intro" onclick="useQF('intro')">
              <div class="fbtn-nm">👋 Strong Intro</div>
              <div class="fbtn-ds">Who you are & why you're calling</div>
            </button>
            <button class="fbtn" id="qf-mirror" onclick="useQF('mirror')">
              <div class="fbtn-nm">🪞 Mirror Pain</div>
              <div class="fbtn-ds">Reflect their words back</div>
            </button>
            <button class="fbtn" id="qf-layer2" onclick="useQF('layer2')">
              <div class="fbtn-nm">🔍 Dig Deeper</div>
              <div class="fbtn-ds">Ask the follow-up question</div>
            </button>
            <button class="fbtn" id="qf-impl" onclick="useQF('implication')">
              <div class="fbtn-nm">💡 Cost of Inaction</div>
              <div class="fbtn-ds">Make staying put feel expensive</div>
            </button>
          </div>
          <button class="meet-btn" id="meet-btn" onclick="useQF('meeting')">
            📅 Ask for a Meeting
            <span class="lock" id="meet-lock">🔒 Need Trust ≥ 50</span>
          </button>
        </div>
      </div>
      <!-- RIGHT -->
      <div class="cpanel right" id="coach-panel">
        <div class="phdr">Coach Hint</div>
        <div class="cbox" id="cbox">Start with a warm intro — who you are, EXL, and <strong>why this call makes sense
            for Marcus</strong>.</div>
        <div style="padding:0 12px;margin-top:4px">
          <div
            style="font-size:10px;font-family:'DM Mono',monospace;color:var(--td);letter-spacing:.1em;padding:10px 0 8px;text-transform:uppercase">
            Pillar Scores</div>
          <div class="scrow"><span class="sc-lbl">Introduction</span>
            <div class="sc-bar" style="width:70px">
              <div class="sc-fill" id="ps0" style="width:0%"></div>
            </div><span class="sc-pct" id="psp0">0%</span>
          </div>
          <div class="scrow"><span class="sc-lbl">Mirroring</span>
            <div class="sc-bar" style="width:70px">
              <div class="sc-fill" id="ps1" style="width:0%"></div>
            </div><span class="sc-pct" id="psp1">0%</span>
          </div>
          <div class="scrow"><span class="sc-lbl">Curiosity</span>
            <div class="sc-bar" style="width:70px">
              <div class="sc-fill" id="ps2" style="width:0%"></div>
            </div><span class="sc-pct" id="psp2">0%</span>
          </div>
          <div class="scrow"><span class="sc-lbl">Implication</span>
            <div class="sc-bar" style="width:70px">
              <div class="sc-fill" id="ps3" style="width:0%"></div>
            </div><span class="sc-pct" id="psp3">0%</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ════ TUTORIAL OVERLAY ════ -->
  <div class="tut-overlay" id="tut-overlay">
    <div class="tut-backdrop"></div>
    <div class="tut-spotlight" id="tut-spotlight"></div>
    <div class="tut-card" id="tut-card">
      <div class="tut-dots" id="tut-dots"></div>
      <div class="tut-step" id="tut-step">STEP 1 OF 4</div>
      <div class="tut-title" id="tut-title">Trust Score</div>
      <div class="tut-body" id="tut-body">The higher this goes, the easier it becomes to ask for a meeting — and close
        the deal.</div>
      <button class="btn bp" style="width:100%;padding:12px" onclick="nextTutStep()">Got it →</button>
    </div>
  </div>

  <!-- ════ S8 FAIL ════ -->
  <div class="scr" id="s-fail">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
    </div>
    <div class="ctr centered" style="gap:24px">
      <div class="fail-box" style="max-width:600px;width:100%">
        <div class="fail-top">
          <div style="font-size:40px">📉</div>
          <div>
            <h3 style="color:#fff">Call Ended Early</h3>
            <p style="font-size:15px;color:rgba(255,255,255,.75);margin-top:3px" id="fail-reason">Trust dropped too low.
            </p>
          </div>
        </div>
        <div class="fail-body">
          <div id="fail-fb"></div>
          <div style="display:flex;gap:10px;padding-top:6px"><button class="btn bs" onclick="go('s-lead')">← Review
              Lead</button><button class="btn bp big" onclick="go('s-lead');initCall()">Try Again →</button></div>
        </div>
      </div>
    </div>
  </div>

  <!-- ════ S9 MEETING SET ════ -->
  <div class="scr" id="s-meeting">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
    </div>
    <div class="meeting-split" style="flex:1">
      <div class="meeting-left">
        <div style="position:relative;z-index:1">
          <div style="font-size:56px;margin-bottom:20px;animation:po .5s cubic-bezier(.34,1.56,.64,1)">🤝</div>
          <span class="tag"
            style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);margin-bottom:16px;display:inline-block">MEETING
            CONFIRMED</span>
          <h2 style="color:#fff;font-size:32px;margin-bottom:12px">That's how it's done.</h2>
          <p style="font-size:17px;color:rgba(255,255,255,.8);line-height:1.65">"Send me a Tuesday 3 PM invite — I'll
            loop in the Head of CS and CFO."</p>
          <p style="font-size:14px;color:rgba(255,255,255,.5);margin-top:8px">— Marcus Chen, COO · Aethelgard Life</p>
          <div
            style="display:flex;align-items:center;gap:12px;margin-top:28px;background:rgba(255,255,255,.12);border-radius:12px;padding:14px 18px">
            <div
              style="width:48px;height:48px;border-radius:50%;overflow:hidden;flex-shrink:0;border:2px solid rgba(255,255,255,.4)">
              <img src="https://i.pravatar.cc/48?img=57" style="width:100%;height:100%;object-fit:cover" alt="Marcus">
            </div>
            <div>
              <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:#fff">Marcus Chen</div>
              <div style="font-size:13px;color:rgba(255,255,255,.6)">COO · Aethelgard Life</div>
            </div>
          </div>
        </div>
      </div>
      <div class="meeting-right">
        <h3 style="font-size:18px">What you uncovered</h3>
        <div id="meeting-insights"></div>
        <div id="redo-hint"
          style="display:none;background:var(--ambd);border:1px solid rgba(217,119,6,.2);border-radius:var(--rads);padding:12px 14px;font-size:14px;color:var(--tm)">
          💡 You missed some insights. <button class="btn bs" style="padding:6px 14px;font-size:13px;margin-left:8px"
            onclick="go('s-lead');initCall()">Redo the call →</button>
        </div>
        <button class="btn bp big" onclick="go('s-solution')">Choose Your Solution →</button>
      </div>
    </div>
  </div>

  <!-- ════ S10 SOLUTION ════ -->
  <div class="scr" id="s-solution">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div><span style="font-size:13px;color:var(--tm)">Solution Mapping</span>
    </div>
    <div class="ctr" style="gap:28px">
      <div><span class="tag ta" style="margin-bottom:12px;display:inline-block">PICK THE RIGHT FIT</span>
        <h2>Which solution fits Marcus?</h2>
        <p class="sub" style="margin-top:8px">Two are wrong. Think about his constraints.</p>
      </div>
      <div class="sol-grid">
        <div class="sol-c" onclick="checkSol(this,'wrong','analytics')">
          <div class="sol-ic">📊</div>
          <div class="sol-nm">Analytics Cloud</div>
          <div class="sol-ds">BI dashboards and predictive modelling for data-first mandates.</div><span
            class="tag td2">Data · Insights</span>
        </div>
        <div class="sol-c" onclick="checkSol(this,'ok','orch')">
          <div class="sol-ic">🔗</div>
          <div class="sol-nm">Operations Orchestration Suite</div>
          <div class="sol-ds">Workflow layer across legacy PAS. Coexistence-first. Phased rollout. No core replacement.
          </div><span class="tag tok">Operations · PAS</span>
        </div>
        <div class="sol-c" onclick="checkSol(this,'wrong','uw')">
          <div class="sol-ic">🤖</div>
          <div class="sol-nm">AI Underwriting Engine</div>
          <div class="sol-ds">Automated risk scoring for underwriting teams.</div><span class="tag td2">Underwriting ·
            AI</span>
        </div>
      </div>
      <div id="sol-fb"
        style="display:none;width:100%;background:var(--rd);border:1px solid var(--rb);border-radius:var(--rads);padding:14px 18px;font-size:15px;color:var(--r);line-height:1.6">
      </div>
    </div>
  </div>

  <!-- ════ S11 DECK BUILDER ════ -->
  <div class="scr" id="s-deck" style="overflow:hidden;height:100vh">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
      <span style="font-size:13px;color:var(--tm)">Pitch Deck Customisation</span>
      <div class="ml"><span style="font-size:14px;color:var(--tm)">Fixes needed: <span id="chg-left"
            style="color:var(--amber);font-weight:700">3</span></span></div>
    </div>
    <div class="deck-wrap">
      <div class="deck-main" id="deck-slides"></div>
      <div class="chg-panel">
        <div class="chg-intro"><strong>This is your master pitch deck agenda.</strong><br><br>What would you customise
          for Marcus? Pick the 3 changes that matter to him.</div>
        <div
          style="font-size:11px;font-family:'DM Mono',monospace;color:var(--td);letter-spacing:.08em;margin-top:2px;text-transform:uppercase">
          Select Changes</div>
        <div id="chg-btns" style="display:flex;flex-direction:column;gap:7px"></div>
      </div>
    </div>
  </div>

  <!-- ════ S12 DECK DONE ════ -->
  <div class="scr" id="s-deck-done">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
    </div>
    <div class="deck-done-split" style="flex:1">
      <div class="deck-done-left">
        <div style="font-size:52px;animation:po .5s cubic-bezier(.34,1.56,.64,1)">🎯</div>
        <span class="tag"
          style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.2);align-self:flex-start">DECK
          READY</span>
        <h2 style="color:#fff">Smart deck. Sharp pitch.</h2>
        <p style="font-size:17px;color:rgba(255,255,255,.7);line-height:1.65">Your pitch now speaks directly to
          Aethelgard's three biggest concerns.</p>
      </div>
      <div class="deck-done-right">
        <h3>Changes made</h3>
        <div style="display:flex;flex-direction:column;gap:10px">
          <div style="display:flex;gap:12px;align-items:flex-start;font-size:16px;color:var(--tx);line-height:1.55">
            <span style="color:var(--ok);font-size:18px;flex-shrink:0">✅</span>Phased rollout — entity by entity</div>
          <div style="display:flex;gap:12px;align-items:flex-start;font-size:16px;color:var(--tx);line-height:1.55">
            <span style="color:var(--ok);font-size:18px;flex-shrink:0">✅</span>Managed support — EXL owns it</div>
          <div style="display:flex;gap:12px;align-items:flex-start;font-size:16px;color:var(--tx);line-height:1.55">
            <span style="color:var(--ok);font-size:18px;flex-shrink:0">✅</span>99.8% uptime SLA + compliance</div>
        </div>
        <button class="btn bp big" style="align-self:flex-start;margin-top:8px"
          onclick="go('s-pitch');initPitch()">Start the Pitch Meeting →</button>
      </div>
    </div>
  </div>

  <!-- ════ S13 PITCH ════ -->
  <div class="scr" id="s-pitch" style="overflow:hidden;height:100vh">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
      <span style="font-size:13px;color:var(--tm)">Pitch Meeting · Aethelgard Life</span>
      <div class="ml" style="display:flex;gap:10px;align-items:center">
        <span id="ptimer" style="font-size:13px;color:var(--amber);font-family:'DM Mono',monospace">⏱ 00:00</span>
        <button class="btn bd" style="padding:6px 14px;font-size:13px" onclick="endPitchEarly()">End Meeting</button>
      </div>
    </div>
    <div class="pbar">
      <div class="pb" id="pprog" style="width:50%"></div>
    </div>
    <div class="pitch-wrap" style="flex:1;min-height:0">
      <div class="pmain">
        <div class="avrow" id="avrow"></div>
        <div class="pslide">
          <div class="psl-h">
            <div class="psl-meta">SLIDE <span id="csl-n">1</span> OF 7</div>
            <div class="psl-title" id="csl-t">EXL Operations Orchestration Suite</div>
            <div class="psl-sub" id="csl-s">A phased path to harmony</div>
          </div>
          <div class="psl-body" id="csl-b"></div>
          <div class="psl-nav">
            <button class="btn bs" style="font-size:13px;padding:8px 16px" onclick="prevSlide()">← Prev</button>
            <button class="btn bp" style="font-size:13px;padding:8px 16px" onclick="nextSlide()">Next →</button>
            <button class="btn bs" style="font-size:13px;padding:8px 16px;margin-left:auto" onclick="askQ()">Open to
              Questions</button>
          </div>
        </div>
        <div class="vcall-area">
          <div class="vcall-hdr">
            <div class="ld"></div> Room Conversation
          </div>
          <div class="vcall-tx" id="vcall-tx"></div>
          <div class="vframes">
            <button class="vf" id="vf0" onclick="pitchFrame(0)">📖 Share an outcome story</button>
            <button class="vf" id="vf1" onclick="pitchFrame(1)">🛡️ Cite a reference</button>
            <button class="vf" id="vf2" onclick="pitchFrame(2)">🌍 Connect to their reality</button>
            <button class="vf" id="vf3" onclick="pitchFrame(3)">🤝 Propose next steps</button>
          </div>
        </div>
        <div class="obj-bub" id="obj-bub">
          <div class="obj-who" id="obj-who"></div>
          <div id="obj-text"></div>
          <div class="obj-opts" id="obj-opts"></div>
        </div>
      </div>
      <div class="pright">
        <div class="phdr">Room Trust</div>
        <div style="padding:12px;display:flex;flex-direction:column;gap:7px" id="stk-panel"></div>
        <div class="phdr" style="margin-top:4px">Score Levers</div>
        <div style="padding:12px;display:flex;flex-direction:column;gap:0">
          <div class="scrow"><span class="sc-lbl" style="font-size:13px">Outcome Stories</span>
            <div class="sc-bar" style="width:60px">
              <div class="sc-fill" id="ps0" style="width:0%"></div>
            </div><span class="sc-pct" id="psp0">0%</span>
          </div>
          <div class="scrow"><span class="sc-lbl" style="font-size:13px">Evidence</span>
            <div class="sc-bar" style="width:60px">
              <div class="sc-fill" id="ps1" style="width:0%"></div>
            </div><span class="sc-pct" id="psp1">0%</span>
          </div>
          <div class="scrow"><span class="sc-lbl" style="font-size:13px">Objections</span>
            <div class="sc-bar" style="width:60px">
              <div class="sc-fill" id="ps2" style="width:0%"></div>
            </div><span class="sc-pct" id="psp2">0%</span>
          </div>
          <div class="scrow"><span class="sc-lbl" style="font-size:13px">Reality</span>
            <div class="sc-bar" style="width:60px">
              <div class="sc-fill" id="ps3" style="width:0%"></div>
            </div><span class="sc-pct" id="psp3">0%</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ════ S14 PITCH FAIL ════ -->
  <div class="scr" id="s-pitch-fail">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
    </div>
    <div class="ctr centered" style="gap:24px">
      <div class="fail-box" style="max-width:600px;width:100%">
        <div class="fail-top">
          <div style="font-size:40px">😓</div>
          <div>
            <h3 style="color:#fff">Meeting Cut Short</h3>
            <p style="font-size:15px;color:rgba(255,255,255,.75);margin-top:3px">"This doesn't feel like the right fit
              right now." — CEO</p>
          </div>
        </div>
        <div class="fail-body">
          <div id="pfail-fb"></div>
          <div style="display:flex;gap:10px;padding-top:6px"><button class="btn bs" onclick="go('s-deck-done')">← Revise
              Deck</button><button class="btn bp big" onclick="restartPitch()">Try Again →</button></div>
        </div>
      </div>
    </div>
  </div>

  <!-- ════ S15 WIN ════ -->
  <div class="scr" id="s-win">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
    </div>
    <div class="win-split" style="flex:1">
      <div class="win-left">
        <div style="position:relative;z-index:1">
          <div style="font-size:56px;margin-bottom:20px;animation:po .5s cubic-bezier(.34,1.56,.64,1)">🏆</div>
          <span class="tag"
            style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);margin-bottom:16px;display:inline-block">DEAL
            CLOSED</span>
          <h2 style="color:#fff;margin-bottom:12px">You closed it.</h2>
          <p style="font-size:17px;color:rgba(255,255,255,.8);line-height:1.65">"We're moving forward. I'll loop in
            legal and billing."</p>
          <p style="font-size:14px;color:rgba(255,255,255,.5);margin-top:8px">— Elena Voss, CEO · Aethelgard Life</p>
          <div style="display:flex;gap:-8px;margin-top:24px">
            <img src="https://i.pravatar.cc/44?img=57"
              style="width:44px;height:44px;border-radius:50%;border:3px solid rgba(255,255,255,.6);object-fit:cover;margin-right:6px"
              alt="Marcus">
            <img src="https://i.pravatar.cc/44?img=47"
              style="width:44px;height:44px;border-radius:50%;border:3px solid rgba(255,255,255,.6);object-fit:cover;margin-right:6px"
              alt="Elena">
            <img src="https://i.pravatar.cc/44?img=29"
              style="width:44px;height:44px;border-radius:50%;border:3px solid rgba(255,255,255,.6);object-fit:cover"
              alt="Priya">
          </div>
        </div>
      </div>
      <div class="win-right">
        <h3>Your results</h3>
        <div class="rmet-grid">
          <div class="rmet">
            <div class="rmet-v" style="color:var(--ok)" id="rep-ts">+82</div>
            <div class="rmet-l">TRUST SCORE</div>
          </div>
          <div class="rmet">
            <div class="rmet-v" id="rep-ins">4/4</div>
            <div class="rmet-l">INSIGHTS</div>
          </div>
          <div class="rmet">
            <div class="rmet-v" style="color:var(--ok)" id="rep-avg">94</div>
            <div class="rmet-l">ROOM TRUST</div>
          </div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap"><button class="btn bs" onclick="go('s-lead')">Play
            Again</button><button class="btn bp big" onclick="go('s-cert')">Get Certificate →</button></div>
      </div>
    </div>
  </div>

  <!-- ════ S16 CERT ════ -->
  <div class="scr" id="s-cert">
    <div class="tb">
      <div class="logo">
        <div class="ld"></div>EXL PITCH SIM
      </div>
    </div>
    <div class="ctr centered" style="gap:24px">
      <div class="cert">
        <div style="font-family:'DM Mono',monospace;font-size:11px;color:var(--td);letter-spacing:.14em">EXL SERVICE
          LIMITED · SALES EXCELLENCE</div>
        <div class="cert-badge">🏆</div>
        <div style="font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--td);letter-spacing:.12em">
          CERTIFICATE OF COMPLETION</div>
        <h2 style="font-size:26px">Level 1: Discovery</h2>
        <div style="font-size:16px;color:var(--tm);line-height:1.8">Awarded to<br><strong id="cert-name"
            style="font-family:'Syne',sans-serif;font-size:22px;color:var(--tx);display:block;margin:6px 0">Rahul
            Sharma</strong>Trust Score <strong id="cert-score" style="color:var(--acc)">+82</strong> · Closed Aethelgard
          Life</div>
        <div class="cert-sigs">
          <div class="cert-sig">
            <div class="cert-line"></div>
            <div class="cert-lbl">L&D Programme Lead</div>
          </div>
          <div class="cert-sig">
            <div class="cert-line"></div>
            <div class="cert-lbl">EXL Sales Excellence</div>
          </div>
        </div>
        <div style="font-family:'DM Mono',monospace;font-size:11px;color:var(--td)">Issued <span id="cert-date"></span>
        </div>
      </div>
      <div style="display:flex;gap:10px"><button class="btn bs"
          onclick="sf('📄','Download','PDF export available in production.',false,2200)">⬇ Download PDF</button><button
          class="btn bs" onclick="sf('↗','Share','Shareable link in production.',false,2200)">↗ Share</button><button
          class="btn bp big" onclick="go('s-imu')">Back to Start</button></div>
    </div>
  </div>

  <!-- FLASH -->
  <div class="flash" id="flash" onclick="this.classList.remove('on')">
    <div class="flash-bg"></div>
    <div class="flash-con" id="flash-con"></div>
  </div>

  <script>
    const S = { name: '', trustScore: 0, insightsFound: 0, callSeconds: 0, callInterval: null, callRunning: false, callPhase: 0, qfUsed: {}, scoreVals: [0, 0, 0, 0], pitchSeconds: 0, pitchInterval: null, pitchSlide: 0, stkScores: { coo: 50, ceo: 50, cs: 50 }, objPhase: 0, pitchScores: [0, 0, 0, 0], pitchFrameUsed: {} };
    const INSIGHTS = [{ l: 'Current Challenge', t: 'Staff bypassing CRM — manual Excel everywhere.' }, { l: 'Where It Hurts', t: 'Top advisors are leaving. Tools make them look incompetent.' }, { l: 'What They\'ve Tried', t: 'Core PAS replacement failed. $8M written off. No big-bang rule is firm.' }, { l: 'Non-Negotiables', t: 'Phased rollout per entity. Vendor owns support & maintenance.' }];
    const QF = { intro: { ts: 15, sc: [80, 0, 0, 0], coach: 'Great start. Now ask how the post-acquisition integration is going.', line: 'Marcus — I\'m from EXL. We work with multi-market insurers in exactly your situation. Worth 10 minutes?' }, mirror: { ts: 13, sc: [0, 90, 0, 0], coach: 'Perfect mirror. Now push — what\'s the annual cost of this problem?', line: 'So if I\'m hearing you right — this isn\'t just a tech problem, it\'s showing up in advisor churn and your Cost-to-Serve. Have I got that right?' }, layer2: { ts: 12, sc: [0, 0, 85, 0], coach: 'Strong. Follow up — what happens if this sits for another year?', line: 'When your CEO says "harmonise operations" — is he anchoring on Cost-to-Serve, or is there an advisor retention number behind it?' }, implication: { ts: 14, sc: [0, 0, 0, 90], coach: 'Excellent. Try to put a number to it — how much per quarter?', line: 'If advisor attrition continues at this pace, what does your distribution capacity look like in 18 months?' }, meeting: { ts: 0, sc: [0, 0, 0, 0], line: '' } };
    const CLI = [{ u: null, t: 'Sure — what\'s EXL\'s angle?' }, { u: 0, t: 'Honestly, the biggest issue is staff have abandoned our CRM. They work in Excel because it\'s faster. Embarrassing to admit.' }, { u: 1, t: 'The ripple effect is worse. Our best advisors — 200+ client books — they\'re leaving. They say the tools make them look incompetent.' }, { u: 2, t: 'We tried a full core replacement two years ago. Six months in, pulled the plug. $8M written off. Board is allergic to "platform migration" now.' }, { u: 3, t: 'Any solution must roll out entity by entity. And the vendor has to own support. My team can\'t babysit an integration.' }, { u: null, t: 'This has been more useful than expected. What\'s a next step?' }];
    const PITCH_SLIDES = [{ t: 'EXL Operations Orchestration Suite', s: 'Built for Aethelgard\'s exact situation', p: ['Coexistence-first — no core replacement', 'Works across fragmented PAS systems', 'Trusted by 6 of the top 20 global life insurers'] }, { t: 'What We Heard', s: 'Your challenges, in your words', p: ['Staff in Excel — CRM abandoned', 'Top advisors leaving due to tool friction', '$8M big-bang failure — the "no migration" rule is real'] }, { t: 'How It Works', s: 'Orchestration layer — sits between systems', p: ['API wrapper across PAS — zero schema changes', 'Unified servicing workflow for advisor teams', 'Real-time policy status — 40% fewer manual queries'] }, { t: 'Phased Rollout', s: 'Entity by entity — your way', p: ['Month 1–3: Singapore pilot', 'Month 4–6: EU entity', 'Month 7–12: APAC holdcos, certified one by one'] }, { t: 'We Own the Support', s: 'Managed services, SLA-backed', p: ['Dedicated integration manager from Day 1', '24/7 Tier-1 support across APAC + EU', 'Quarterly business reviews with COO and CIO'] }, { t: 'Guarantees', s: 'Enterprise-grade assurance', p: ['99.8% uptime — contractually backed', 'GDPR, MAS, Solvency II compliant', 'Audit-ready reporting'] }, { t: 'Proof It Works', s: 'Comparable insurer, 14 months', p: ['Tier-1 EU insurer — 4 PAS systems post-acquisition', 'Cost-to-Serve down 15%', 'Advisor contact rate −38% · Attrition −60%'] }];
    const STKS = [{ key: 'coo', name: 'Marcus Chen', role: 'COO', img: 'https://i.pravatar.cc/68?img=57', col: '#fb4e0b' }, { key: 'ceo', name: 'Elena Voss', role: 'CEO', img: 'https://i.pravatar.cc/68?img=47', col: '#1a1a18' }, { key: 'cs', name: 'Priya Mehta', role: 'Head of CS', img: 'https://i.pravatar.cc/68?img=29', col: '#d97706' }];
    const OBJECTIONS = [{ who: 'MARCUS CHEN · COO', sk: 'coo', q: 'How do you guarantee 99.8% uptime when our legacy PAS vendors have never had consistent API availability?', opts: ['Pre-deployment API audit — async fallback in contract', 'We\'ll sort that out during implementation', 'Our platform handles it automatically'], good: 'Specific and credible — the audit + contractual fallback removes risk from their side.', bad: 'Vague. A COO needs technical confidence, not a sales promise.' }, { who: 'PRIYA MEHTA · HEAD OF CS', sk: 'cs', q: 'My team has been burned by training before. What does onboarding look like?', opts: ['Embedded change management team — no extra cost to your team', 'Training is a client responsibility', 'Standard training, it\'ll be fine'], good: 'Empathetic and concrete — embedded change management directly addresses her concern.', bad: 'Dismissive. She needs a real answer.' }, { who: 'ELENA VOSS · CEO', sk: 'ceo', q: 'Multi-year commitment. The board needs a clear break-even. What does that look like?', opts: ['15% Cost-to-Serve across 3 entities → break-even at month 16. Happy to walk through the model.', 'I can send a model after the meeting', 'ROI is very strong — you\'ll see it'], good: 'Board-ready. Confident and data-backed.', bad: '"Send later" signals unpreparedness.' }];
    const OBJ_CORRECT = [0, 0, 0];
    const PITCH_FRAMES = [{ ts: 12, line: 'In a comparable EU life insurer — 4 PAS systems, same acquisitions story — Cost-to-Serve down 15% in 14 months. Without touching core.' }, { ts: 10, line: 'We\'ve done this 6 times across Tier-1 insurers. The API audit isn\'t standard — it\'s how we protect you contractually from day one.' }, { ts: 11, line: 'Marcus, you mentioned the "no big-bang" rule. Our phased model was designed for exactly that — each entity certified before the next begins.' }, { ts: 8, line: 'What would make sense as a next step — a working session with your CIO and integration team on the technical architecture?' }];

    function go(id) { document.querySelectorAll('.scr').forEach(s => s.classList.remove('on')); document.getElementById(id).classList.add('on'); window.scrollTo(0, 0); }
    function pad(n) { return String(n).padStart(2, '0'); }

    // LOGIN
    function doLogin() { const id = document.getElementById('emp-id').value.trim(), nm = document.getElementById('emp-name').value.trim(); if (!id || !nm) { document.getElementById('lerr').style.display = 'block'; return; } S.name = nm; const init = nm.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2), short = nm.split(' ')[0] + (nm.split(' ')[1] ? ' ' + nm.split(' ')[1][0] + '.' : ''); document.querySelectorAll('.uav').forEach(e => { if (!e.querySelector('img')) e.textContent = init; });['un1', 'un2'].forEach(i => { const el = document.getElementById(i); if (el) el.textContent = short; }); go('s-imu'); }

    // IMU
    function pickIMU(el) { document.querySelectorAll('.imu-c').forEach(c => c.classList.remove('sel')); el.classList.add('sel'); document.getElementById('imu-go').style.display = 'inline-flex'; }

    // PILLARS
    document.getElementById('s-pillars').addEventListener('animationend', () => { document.querySelectorAll('.pc').forEach((c, i) => setTimeout(() => c.classList.add('on'), i * 90)); setTimeout(() => document.getElementById('sbw').classList.add('on'), document.querySelectorAll('.pc').length * 90 + 400); });

    // TUTORIAL
    const TUT_STEPS = [{ targetId: 'ts-panel-hdr', pos: 'right', title: 'Your Trust Score', body: 'The higher this goes, the easier it is to ask for a meeting — and close the deal.' }, { targetId: 'meet-btn', pos: 'top', title: 'Ask for a Meeting', body: 'This unlocks when Trust hits 50. Use your conversation frames to build up to it.' }, { targetId: 'insights-panel', pos: 'right', title: 'Hidden Insights', body: 'Marcus is hiding 4 insights. Draw them out through your questions.' }, { targetId: 'scores-strip', pos: 'left', title: 'Your Pillar Scores', body: 'These track how well you\'re executing each discovery pillar. Nail all 4 to maximise trust.' }];
    let tutStep = 0;

    function startCallWithTutorial() { go('s-call'); initCall(); setTimeout(() => { tutStep = 0; renderTutStep(); document.getElementById('tut-overlay').classList.add('on'); }, 600); }

    function renderTutStep() {
      const step = TUT_STEPS[tutStep];
      const card = document.getElementById('tut-card'), spot = document.getElementById('tut-spotlight'), target = document.getElementById(step.targetId);
      document.getElementById('tut-step').textContent = 'STEP ' + (tutStep + 1) + ' OF ' + TUT_STEPS.length;
      document.getElementById('tut-title').textContent = step.title;
      document.getElementById('tut-body').textContent = step.body;
      const dots = document.getElementById('tut-dots'); dots.innerHTML = '';
      TUT_STEPS.forEach((_, i) => { const d = document.createElement('div'); d.className = 'tut-dot' + (i === tutStep ? ' on' : ''); dots.appendChild(d); });
      if (target) { const r = target.getBoundingClientRect(); spot.style.cssText = `left:${r.left - 8}px;top:${r.top - 8}px;width:${r.width + 16}px;height:${r.height + 16}px`; const cw = 300, ch = 180; let cl, ct; if (step.pos === 'right') { cl = r.right + 20; ct = r.top; } else if (step.pos === 'left') { cl = r.left - cw - 20; ct = r.top; } else { cl = r.left; ct = r.top - ch - 20; } cl = Math.max(12, Math.min(cl, window.innerWidth - cw - 12)); ct = Math.max(12, Math.min(ct, window.innerHeight - ch - 12)); card.style.cssText = `left:${cl}px;top:${ct}px`; }
    }
    function nextTutStep() { tutStep++; if (tutStep >= TUT_STEPS.length) document.getElementById('tut-overlay').classList.remove('on'); else renderTutStep(); }

    // CALL ENGINE
    function initCall() { S.trustScore = 0; S.insightsFound = 0; S.callPhase = 0; S.callSeconds = 0; S.callRunning = false; S.qfUsed = {}; S.scoreVals = [0, 0, 0, 0]; clearInterval(S.callInterval); S.callInterval = null; document.getElementById('txbox').innerHTML = ''; updateTS(0);[0, 1, 2, 3].forEach(i => { document.getElementById('id' + i).className = 'idot hid'; document.getElementById('it' + i).textContent = ['Current Challenge', 'Where It Hurts', 'What They\'ve Tried', 'Non-Negotiables'][i]; const lh = document.getElementById('lh' + i); if (lh) { lh.className = 'hcard'; lh.innerHTML = '<span style="font-size:16px">🔒</span><span class="hcard-lbl">' + INSIGHTS[i].l + '</span>'; } });[0, 1, 2, 3].forEach(i => { ['sc' + i, 'ps' + i].forEach(id => { const el = document.getElementById(id); if (el) el.style.width = '0%'; });['scp' + i, 'psp' + i].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = '0%'; }); }); S.scoreVals = [0, 0, 0, 0]; document.getElementById('meet-banner').classList.remove('on'); unlockMeet(false); startTimer(); setTimeout(() => addTx('cli', 'Marcus Chen', 'Thanks for reaching out. I have about 15 minutes — what\'s this about?'), 700); setCoach('Start with a warm intro — who you are, EXL, and <strong>why this call makes sense for Marcus</strong>.'); }

    function startTimer() { S.callRunning = true; clearInterval(S.callInterval); S.callInterval = setInterval(() => { if (!S.callRunning) return; S.callSeconds++; const el = document.getElementById('ctimer'); if (el) el.textContent = '⏱ ' + pad(Math.floor(S.callSeconds / 60)) + ':' + pad(S.callSeconds % 60); }, 1000); }
    function stopTimer() { S.callRunning = false; clearInterval(S.callInterval); S.callInterval = null; }

    function addTx(type, who, text) { const box = document.getElementById('txbox'); if (!box) return; const d = document.createElement('div'); d.className = 'txl ' + type; const lbl = type === 'cli' ? 'MARCUS CHEN' : type === 'usr' ? 'YOU' : ''; d.innerHTML = (lbl ? '<div class="txlbl">' + lbl + '</div>' : '') + text; box.appendChild(d); box.scrollTop = box.scrollHeight; if (type === 'cli') { speak(true); setTimeout(() => speak(false), Math.min(text.length * 20, 2600)); } }
    function speak(on) { ['pr1', 'pr2'].forEach(id => { const el = document.getElementById(id); if (el) el.classList.toggle('sp', on); }); const b = document.getElementById('pbadge'); if (b) { b.textContent = on ? 'speaking…' : 'listening…'; } }
    function setCoach(h) { const el = document.getElementById('cbox'); if (el) el.innerHTML = h; }
    function unlockMeet(on) { const btn = document.getElementById('meet-btn'), lock = document.getElementById('meet-lock'); if (!btn) return; btn.classList.toggle('unlocked', on); lock.textContent = on ? '✓ Ready' : '🔒 Need Trust ≥ 50'; }

    function useQF(type) { if (!S.callRunning) return; if (type === 'meeting') { reqMeeting(); return; } const d = QF[type]; if (!d) return; const used = S.qfUsed[type] || 0; S.qfUsed[type] = used + 1; const btn = document.getElementById('qf-' + type); if (btn) btn.classList.add('used'); addTx('usr', 'YOU', d.line); d.sc.forEach((v, i) => { if (v > 0) { const nv = Math.min(100, (S.scoreVals[i] || 0) + (used === 0 ? v : Math.floor(v * .35))); S.scoreVals[i] = nv;['sc' + i, 'ps' + i].forEach(id => { const el = document.getElementById(id); if (el) el.style.width = nv + '%'; });['scp' + i, 'psp' + i].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = nv + '%'; }); } }); updateTS(S.trustScore + (used === 0 ? d.ts : Math.floor(d.ts * .35))); const resp = CLI[Math.min(S.callPhase, CLI.length - 1)]; setTimeout(() => { addTx('cli', 'Marcus Chen', resp.t); if (resp.u !== null && resp.u !== undefined) { const dot = document.getElementById('id' + resp.u); if (dot && !dot.classList.contains('fnd')) revealInsight(resp.u); } if (S.callPhase < CLI.length - 1) S.callPhase++; }, 1300); setCoach(used === 0 ? d.coach : 'Good — try a <strong>different frame</strong> to keep building trust.'); }

    function revealInsight(i) { S.insightsFound++; document.getElementById('id' + i).className = 'idot fnd'; document.getElementById('it' + i).innerHTML = '<span style="color:var(--ok);font-weight:700">' + INSIGHTS[i].l + ':</span> ' + INSIGHTS[i].t; const lh = document.getElementById('lh' + i); if (lh) { lh.className = 'hcard found'; lh.innerHTML = '<span style="font-size:16px">✅</span><div><span style="font-weight:700;color:var(--tx)">' + INSIGHTS[i].l + '</span><br><span style="font-size:12px;color:var(--tm)">' + INSIGHTS[i].t + '</span></div>'; } sf('✓', 'Insight Unlocked', INSIGHTS[i].l, false, 1700); }

    function reqMeeting() { if (!S.callRunning) return; addTx('usr', 'YOU', 'Marcus, based on our conversation — can we set up a formal session where I walk through a tailored solution? Tuesday works for me.'); setTimeout(() => { if (S.trustScore >= 50) { stopTimer(); addTx('cli', 'Marcus Chen', "That works. Send a Tuesday 3 PM invite — I'll loop in the Head of CS and CFO."); setTimeout(() => { go('s-meeting'); buildMeetingInsights(); }, 1800); } else if (S.trustScore >= 0) { addTx('cli', 'Marcus Chen', "I'd like to understand the fit better first. Let's keep talking."); setCoach('Keep building trust — use <strong>Mirror</strong> or <strong>Implication</strong> before asking again.'); } else { addTx('cli', 'Marcus Chen', "I don't think a meeting makes sense right now. We'll be in touch if things change."); setTimeout(() => triggerFail('Trust was negative when you asked for the meeting.'), 900); } }, 1200); }

    function updateTS(val) { S.trustScore = Math.max(-100, Math.min(100, val)); const v = S.trustScore, num = document.getElementById('tnum'), bar = document.getElementById('tbar'); if (num) { num.textContent = (v > 0 ? '+' : '') + v; num.className = 'tnum ' + (v > 0 ? 'pos' : v < 0 ? 'neg' : 'neu'); } if (bar) { bar.style.width = ((v + 100) / 200 * 100) + '%'; bar.style.background = v > 0 ? 'var(--ok)' : v < 0 ? 'var(--r)' : 'var(--amber)'; } if (v <= -50 && S.callRunning) setTimeout(() => { if (S.callRunning) triggerFail('Trust dropped below −50. Marcus ended the call.'); }, 700); if (v >= 50) unlockMeet(true); }

    function endCallEarly() { stopTimer(); triggerFail('You ended the call before securing a meeting.'); }
    function triggerFail(reason) { stopTimer(); document.getElementById('fail-reason').textContent = reason; const fb = document.getElementById('fail-fb'); fb.innerHTML = '';[{ ic: '⚡', t: 'Your intro sets the tone. Lead with who you are, EXL, and why this call matters to Marcus.' }, { ic: '🔍', t: 'You found ' + S.insightsFound + ' of 4 insights. Each one makes your pitch more relevant.' }, { ic: '📅', t: 'Only ask for a meeting when Trust ≥ 50. Below that, he hasn\'t seen enough value.' }].forEach(item => { const d = document.createElement('div'); d.className = 'fbi'; d.innerHTML = '<span style="font-size:18px;flex-shrink:0">' + item.ic + '</span>' + item.t; fb.appendChild(d); }); go('s-fail'); }

    function buildMeetingInsights() { const c = document.getElementById('meeting-insights'); c.innerHTML = ''; let missed = 0; INSIGHTS.forEach((ins, i) => { const found = document.getElementById('id' + i).classList.contains('fnd'); if (!found) missed++; const d = document.createElement('div'); d.className = 'ins-row' + (found ? ' fnd' : ''); d.innerHTML = '<span class="ins-ic">' + (found ? '✅' : '🔒') + '</span><div>' + (found ? '<strong>' + ins.l + ':</strong> ' + ins.t : '<span style="color:var(--td)">' + ins.l + '</span> — not uncovered') + '</div>'; c.appendChild(d); }); if (missed > 0) document.getElementById('redo-hint').style.display = 'block'; }

    // SOLUTION
    function checkSol(el, result, key) { if (result === 'ok') { el.classList.add('ok'); document.getElementById('sol-fb').style.display = 'none'; setTimeout(() => { go('s-deck'); initDeck(); }, 500); } else { el.classList.add('wrong'); const msgs = { analytics: 'Analytics Cloud is a data-insights play. Marcus needs operational efficiency.', uw: 'AI Underwriting targets underwriting. Marcus\'s problem is in servicing operations.' }; const fb = document.getElementById('sol-fb'); fb.innerHTML = '<strong>Wrong fit.</strong> ' + msgs[key] + ' Think: coexistence, phased rollout, vendor support.'; fb.style.display = 'block'; setTimeout(() => el.classList.remove('wrong'), 1400); } }

    // DECK
    const BASE_SLIDES = [{ ic: '📋', t: 'Introduction & Agenda', s: 'Who is EXL and why are we here', gap: false, nw: false }, { ic: '🔗', t: 'Technical Architecture', s: 'Coexistence layer across your PAS', gap: false, nw: false }, { ic: '📊', t: 'Value Proposition', s: 'Cost-to-Serve reduction pathway', gap: false, nw: false }, { ic: '📅', t: 'Implementation Timeline', s: 'All entities, one big rollout ⚠', gap: true, nw: false }, { ic: '✅', t: 'Commercial Next Steps', s: 'Terms and contracting', gap: false, nw: false }];
    const CHANGES = [{ id: 'phased', ok: true, l: 'Change rollout to phased — one entity at a time, not all three together' }, { id: 'support', ok: true, l: 'Add managed support slide — EXL owns the integration end-to-end' }, { id: 'sla', ok: true, l: 'Add SLA & compliance guarantees — 99.8% uptime, MAS, GDPR, Solvency II' }, { id: 'price', ok: false, l: 'Add competitive pricing comparison table' }, { id: 'ai', ok: false, l: 'Add AI & ML roadmap slide' }, { id: 'hc', ok: false, l: 'Add EXL global headcount and office locations' }, { id: 'awards', ok: false, l: 'Add analyst recognition and industry awards' }, { id: 'csr', ok: false, l: 'Add EXL corporate responsibility overview' }, { id: 'mkt', ok: false, l: 'Add global insurance market trends slide' }, { id: 'ip', ok: false, l: 'Add EXL IP and patent portfolio' }];
    let chgApplied = 0;

    function initDeck() { chgApplied = 0; document.getElementById('chg-left').textContent = '3'; document.getElementById('chg-left').style.color = 'var(--amber)'; renderSlides(BASE_SLIDES); renderChanges(); }
    function renderSlides(slides) { const c = document.getElementById('deck-slides'); c.innerHTML = ''; slides.forEach((sl, i) => { const d = document.createElement('div'); d.className = 'ppt-slide' + (sl.nw ? ' new-slide' : '') + (sl.gap ? ' gap' : ''); d.innerHTML = '<div class="ppt-top"><div class="ppt-num">' + pad(i + 1) + '</div><div class="ppt-ic">' + sl.ic + '</div><div class="ppt-t">' + sl.t + (sl.gap ? ' <span class="tag tr" style="font-size:9px;vertical-align:middle">FIX NEEDED</span>' : '') + '</div>' + (sl.nw ? '<span class="tag tok" style="font-size:10px">NEW</span>' : '') + '</div><div class="ppt-body">' + sl.s + '</div>'; c.appendChild(d); }); }
    function renderChanges() { const c = document.getElementById('chg-btns'); c.innerHTML = '';[...CHANGES].sort(() => Math.random() - .5).forEach((ch, i) => { const b = document.createElement('button'); b.className = 'chg-btn'; b.id = 'cb-' + ch.id; b.innerHTML = '<span class="chg-n">' + (i < 9 ? '0' + (i + 1) : i + 1) + '</span>' + ch.l; b.onclick = () => applyChange(ch, b); c.appendChild(b); }); }
    function applyChange(ch, btn) { if (btn.classList.contains('ok') || btn.classList.contains('wrong')) return; if (ch.ok) { btn.classList.add('ok'); chgApplied++; const rem = 3 - chgApplied, el = document.getElementById('chg-left'); el.textContent = rem > 0 ? rem : '✓'; el.style.color = rem > 0 ? 'var(--amber)' : 'var(--ok)'; renderSlides(buildUpdatedSlides()); if (chgApplied >= 3) setTimeout(() => go('s-deck-done'), 600); } else { btn.classList.add('wrong'); sf('❌', 'Wrong Choice', 'That doesn\'t address Marcus\'s non-negotiables. Think: phased rollout, support, SLAs.', false, 2200); setTimeout(() => btn.classList.remove('wrong'), 1300); } }
    function buildUpdatedSlides() { const s = [{ ic: '📋', t: 'Introduction & Agenda', s: 'Who is EXL and why are we here', gap: false, nw: false }, { ic: '🔗', t: 'Technical Architecture', s: 'Coexistence layer across your PAS', gap: false, nw: false }, { ic: '📊', t: 'Value Proposition', s: 'Cost-to-Serve reduction pathway', gap: false, nw: false }]; const ph = document.getElementById('cb-phased'), sp = document.getElementById('cb-support'), sl = document.getElementById('cb-sla'); if (ph && ph.classList.contains('ok')) s.push({ ic: '📅', t: 'Phased Rollout — Entity by Entity', s: 'Cascade across 3 insurers at your pace', gap: false, nw: true }); else s.push({ ic: '📅', t: 'Implementation Timeline', s: 'All entities, one big rollout ⚠', gap: true, nw: false }); if (sp && sp.classList.contains('ok')) s.push({ ic: '🛡️', t: 'Managed Support & SLA', s: 'EXL owns the integration — not your team', gap: false, nw: true }); if (sl && sl.classList.contains('ok')) s.push({ ic: '✅', t: '99.8% Uptime + Compliance', s: 'MAS · GDPR · Solvency II — contractually backed', gap: false, nw: true }); s.push({ ic: '📋', t: 'Commercial Next Steps', s: 'Terms and contracting', gap: false, nw: false }); return s; }

    // PITCH
    function initPitch() { S.pitchSeconds = 0; S.pitchSlide = 0; S.objPhase = 0; S.pitchScores = [0, 0, 0, 0]; S.stkScores = { coo: 50, ceo: 50, cs: 50 }; S.pitchFrameUsed = {}; clearInterval(S.pitchInterval); S.pitchInterval = setInterval(() => { S.pitchSeconds++; const el = document.getElementById('ptimer'); if (el) el.textContent = '⏱ ' + pad(Math.floor(S.pitchSeconds / 60)) + ':' + pad(S.pitchSeconds % 60); }, 1000); renderAvatars(); renderStkPanel(); renderPitchSlide(); document.getElementById('obj-bub').classList.remove('on'); document.getElementById('pprog').style.width = '50%'; document.getElementById('vcall-tx').innerHTML = ''; addVTx('sys', '', 'Welcome, Marcus, Elena, Priya — thanks for joining. Let me walk you through our proposal.'); }

    function renderAvatars() { const row = document.getElementById('avrow'); row.innerHTML = ''; STKS.forEach(stk => { const d = document.createElement('div'); d.className = 'stk'; d.id = 'stk-' + stk.key; const sc = S.stkScores[stk.key]; d.innerHTML = `<div class="stk-av" style="border-color:${stk.col}"><img src="${stk.img}" alt="${stk.name}" onerror="this.style.display='none'"></div><div class="stk-nm">${stk.name}</div><div class="stk-rl">${stk.role}</div><div class="stk-bar-wrap"><div class="stk-bar" id="sb-${stk.key}" style="width:${sc}%;background:${tc(sc)}"></div></div><div class="stk-sc" id="ss-${stk.key}">${sc}/100</div>`; row.appendChild(d); }); }
    function renderStkPanel() { const p = document.getElementById('stk-panel'); p.innerHTML = ''; STKS.forEach(stk => { const sc = S.stkScores[stk.key]; const d = document.createElement('div'); d.className = 'stk-mini'; d.innerHTML = `<div class="stk-av-sm" style="border-color:${stk.col}"><img src="${stk.img}" alt="" onerror="this.style.display='none'"></div><div style="flex:1;min-width:0"><div style="font-size:13px;color:var(--tx)">${stk.name}</div><div style="font-size:11px;color:var(--tm)">${stk.role}</div></div><div style="font-family:'DM Mono',monospace;font-size:14px;font-weight:700;color:${tc(sc)}">${sc}</div>`; p.appendChild(d); }); }
    function tc(v) { return v >= 80 ? 'var(--ok)' : v >= 50 ? 'var(--amber)' : 'var(--r)'; }

    function renderPitchSlide() { const sl = PITCH_SLIDES[S.pitchSlide]; document.getElementById('csl-n').textContent = S.pitchSlide + 1; document.getElementById('csl-t').textContent = sl.t; document.getElementById('csl-s').textContent = sl.s; const b = document.getElementById('csl-b'); b.innerHTML = ''; sl.p.forEach(pt => { const d = document.createElement('div'); d.className = 'psl-pt'; d.textContent = pt; b.appendChild(d); }); document.getElementById('pprog').style.width = (50 + ((S.pitchSlide / PITCH_SLIDES.length) * 40)) + '%'; if (S.pitchSlide > 0) bumpPitch(10 + S.pitchSlide * 2); }
    function bumpPitch(by) { STKS.forEach(stk => { S.stkScores[stk.key] = Math.min(90, S.stkScores[stk.key] + Math.floor(by * (.8 + Math.random() * .35))); updateStkUI(stk.key); });[0, 1, 3].forEach(i => { S.pitchScores[i] = Math.min(100, S.pitchScores[i] + Math.floor(by * 1.1)); const b = document.getElementById('ps' + i), p = document.getElementById('psp' + i); if (b) b.style.width = S.pitchScores[i] + '%'; if (p) p.textContent = S.pitchScores[i] + '%'; }); renderStkPanel(); }
    function updateStkUI(key) { const sc = S.stkScores[key], b = document.getElementById('sb-' + key), n = document.getElementById('ss-' + key); if (b) { b.style.width = sc + '%'; b.style.background = tc(sc); } if (n) n.textContent = sc + '/100'; }
    function nextSlide() { if (S.pitchSlide < PITCH_SLIDES.length - 1) { S.pitchSlide++; renderPitchSlide(); } }
    function prevSlide() { if (S.pitchSlide > 0) { S.pitchSlide--; renderPitchSlide(); } }

    function addVTx(type, who, text) { const box = document.getElementById('vcall-tx'); if (!box) return; const d = document.createElement('div'); d.className = 'vtxl ' + type; const lbl = type === 'cli' ? who : type === 'usr' ? 'YOU' : ''; d.innerHTML = (lbl ? '<div class="vtxlbl">' + lbl + '</div>' : '') + text; box.appendChild(d); box.scrollTop = box.scrollHeight; }

    function pitchFrame(i) { if (S.pitchFrameUsed[i]) return; S.pitchFrameUsed[i] = true; const btn = document.getElementById('vf' + i); if (btn) btn.classList.add('used'); const fr = PITCH_FRAMES[i]; addVTx('usr', 'YOU', fr.line); bumpPitch(fr.ts); const reactions = ['That\'s useful — we\'ve heard of similar results but never seen the numbers that clearly.', 'Good to know. The contractual API audit point is something our CIO will want in writing.', 'The phased model is actually what made us agree to this meeting.', 'A working session makes sense. Let\'s confirm the attendees.']; const stkKey = i === 0 ? 'coo' : i === 1 ? 'ceo' : i === 2 ? 'coo' : 'cs'; const stk = STKS.find(s => s.key === stkKey); setTimeout(() => { addVTx('cli', stk.name.toUpperCase() + ' · ' + stk.role.toUpperCase(), reactions[i]); const card = document.getElementById('stk-' + stkKey); if (card) { card.classList.add('spe'); setTimeout(() => card.classList.remove('spe'), 2000); } }, 1200); }

    function askQ() { if (S.objPhase >= OBJECTIONS.length) { checkClose(); return; } const obj = OBJECTIONS[S.objPhase]; document.getElementById('obj-who').textContent = obj.who; document.getElementById('obj-text').textContent = obj.q; const opts = document.getElementById('obj-opts'); opts.innerHTML = ''; const correctTxt = obj.opts[OBJ_CORRECT[S.objPhase]];[...obj.opts].sort(() => Math.random() - .5).forEach(opt => { const b = document.createElement('button'); b.className = 'obj-opt'; b.textContent = opt; b.onclick = () => handleObj(opt === correctTxt, obj, b); opts.appendChild(b); }); document.getElementById('obj-bub').classList.add('on'); STKS.forEach(stk => document.getElementById('stk-' + stk.key).classList.remove('spe', 'obj')); const card = document.getElementById('stk-' + obj.sk); if (card) card.classList.add('obj'); addVTx('cli', obj.who, obj.q); setTimeout(() => { const bub = document.getElementById('obj-bub'); const main = document.querySelector('.pmain'); if (bub && main) main.scrollTo({ top: main.scrollHeight, behavior: 'smooth' }); }, 120); }

    function handleObj(correct, obj, btn) { document.querySelectorAll('.obj-opt').forEach(b => b.style.pointerEvents = 'none'); if (correct) { btn.style.cssText = 'background:var(--okd);border-color:var(--okb);color:var(--ok)'; S.stkScores[obj.sk] = Math.min(100, S.stkScores[obj.sk] + 10); updateStkUI(obj.sk); renderStkPanel(); S.pitchScores[2] = Math.min(100, S.pitchScores[2] + 30); const b = document.getElementById('ps2'), p = document.getElementById('psp2'); if (b) b.style.width = S.pitchScores[2] + '%'; if (p) p.textContent = S.pitchScores[2] + '%'; sf('✓', 'Objection Handled', obj.good, false, 2000); addVTx('usr', 'YOU', btn.textContent); S.objPhase++; setTimeout(() => { document.getElementById('obj-bub').classList.remove('on'); STKS.forEach(stk => document.getElementById('stk-' + stk.key).classList.remove('spe', 'obj')); if (S.objPhase >= OBJECTIONS.length) setTimeout(checkClose, 500); }, 2200); } else { btn.style.cssText = 'background:var(--rd);border-color:var(--rb);color:var(--r)'; S.stkScores[obj.sk] = Math.max(0, S.stkScores[obj.sk] - 8); updateStkUI(obj.sk); renderStkPanel(); sf('✗', 'Weak Response', obj.bad, false, 2200); setTimeout(() => document.querySelectorAll('.obj-opt').forEach(b => b.style.pointerEvents = 'all'), 900); } }

    function checkClose() { clearInterval(S.pitchInterval); const avg = Math.round((S.stkScores.coo + S.stkScores.ceo + S.stkScores.cs) / 3); if (avg >= 82) { document.getElementById('rep-ts').textContent = '+' + S.trustScore; document.getElementById('rep-ins').textContent = S.insightsFound + '/4'; document.getElementById('rep-avg').textContent = avg; document.getElementById('cert-name').textContent = S.name || 'Sales Leader'; document.getElementById('cert-score').textContent = '+' + S.trustScore; document.getElementById('cert-date').textContent = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }); go('s-win'); sf('🏆', 'Deal Closed!', 'Aethelgard Life is moving forward.', true, 0); setTimeout(() => document.getElementById('flash').classList.remove('on'), 3200); } else { sf('💪', 'Keep Going', 'Deliver your closing statement — you\'re close.', false, 2000); } }

    function endPitchEarly() { clearInterval(S.pitchInterval); const fb = document.getElementById('pfail-fb'); fb.innerHTML = '';['Outcome stories beat feature lists. CEOs buy results, not capabilities.', 'Always cite a named reference with a number — vague ROI claims lose deals.', 'When objections arise, acknowledge first. Dismiss and you lose the room.'].forEach(t => { const d = document.createElement('div'); d.className = 'fbi'; d.innerHTML = '<span style="font-size:18px;flex-shrink:0">⚡</span>' + t; fb.appendChild(d); }); go('s-pitch-fail'); }
    function restartPitch() { go('s-pitch'); initPitch(); }

    let fTO = null;
    function sf(ic, title, sub, persist, dur) { clearTimeout(fTO); document.getElementById('flash-con').innerHTML = '<div class="flash-ic">' + ic + '</div><div class="flash-title">' + title + '</div><div class="flash-sub">' + sub + '</div>'; document.getElementById('flash').classList.add('on'); if (!persist) fTO = setTimeout(() => document.getElementById('flash').classList.remove('on'), dur || 2000); }
  </script>
</body>

</html>