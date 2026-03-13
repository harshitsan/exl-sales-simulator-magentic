<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EXL Pitch Simulator</title>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@300;400;500&family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --bg: #080c14;
      --surface: #0d1420;
      --surface2: #111927;
      --border: rgba(255, 255, 255, 0.07);
      --border-bright: rgba(255, 255, 255, 0.14);
      --accent: #00d4aa;
      --accent-dim: rgba(0, 212, 170, 0.12);
      --accent2: #3d8bff;
      --accent2-dim: rgba(61, 139, 255, 0.12);
      --danger: #ff4d6d;
      --danger-dim: rgba(255, 77, 109, 0.12);
      --warn: #ffb830;
      --warn-dim: rgba(255, 184, 48, 0.12);
      --text: #e8eef8;
      --text-muted: #6b7a94;
      --text-dim: #3a4557;
      --radius: 12px;
      --radius-sm: 8px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Grid background */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(0, 212, 170, 0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 212, 170, 0.02) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
    }

    /* ---- TABS NAV ---- */
    .tabs-outer {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 100;
      background: rgba(8, 12, 20, 0.92);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
    }

    .tabs-inner {
      max-width: 1400px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      padding: 0 32px;
      height: 60px;
      gap: 0;
    }

    .logo {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 15px;
      color: var(--accent);
      letter-spacing: 0.08em;
      margin-right: 40px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-dot {
      width: 8px;
      height: 8px;
      background: var(--accent);
      border-radius: 50%;
      box-shadow: 0 0 10px var(--accent);
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.4;
      }
    }

    .tab-btn {
      height: 60px;
      padding: 0 20px;
      border: none;
      background: none;
      color: var(--text-muted);
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      border-bottom: 2px solid transparent;
      transition: all 0.2s;
      position: relative;
      white-space: nowrap;
    }

    .tab-btn:hover {
      color: var(--text);
    }

    .tab-btn.active {
      color: var(--accent);
      border-bottom-color: var(--accent);
    }

    .tab-badge {
      background: var(--accent);
      color: var(--bg);
      font-size: 10px;
      font-weight: 700;
      border-radius: 99px;
      padding: 2px 6px;
      font-family: 'DM Mono', monospace;
    }

    .tab-badge.locked {
      background: var(--text-dim);
      color: var(--text-muted);
    }

    .ml-auto {
      margin-left: auto;
    }

    .user-chip {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 6px 14px;
      border: 1px solid var(--border-bright);
      border-radius: 99px;
      font-size: 12px;
      color: var(--text-muted);
      cursor: default;
    }

    .user-avatar {
      width: 26px;
      height: 26px;
      background: linear-gradient(135deg, var(--accent2), var(--accent));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: 700;
      color: var(--bg);
    }

    /* ---- PAGES ---- */
    .page {
      display: none;
      max-width: 1400px;
      margin: 0 auto;
      padding: 84px 32px 48px;
      position: relative;
      z-index: 1;
      min-height: 100vh;
    }

    .page.active {
      display: block;
    }

    /* ---- PHASE 0: ONBOARDING ---- */
    .onboard-hero {
      padding: 80px 0 60px;
      text-align: center;
    }

    .imu-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--accent-dim);
      border: 1px solid rgba(0, 212, 170, 0.2);
      border-radius: 99px;
      padding: 6px 16px;
      font-size: 11px;
      font-family: 'DM Mono', monospace;
      color: var(--accent);
      letter-spacing: 0.1em;
      margin-bottom: 24px;
    }

    .hero-title {
      font-family: 'Syne', sans-serif;
      font-size: clamp(36px, 5vw, 60px);
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 20px;
      background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.6) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-sub {
      font-size: 15px;
      color: var(--text-muted);
      max-width: 540px;
      margin: 0 auto 48px;
      line-height: 1.7;
    }

    .journey-track {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 2px;
      max-width: 900px;
      margin: 0 auto 60px;
      background: var(--border);
      border-radius: var(--radius);
      overflow: hidden;
    }

    .journey-step {
      background: var(--surface);
      padding: 28px 24px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      cursor: pointer;
      transition: background 0.2s;
      position: relative;
    }

    .journey-step:hover {
      background: var(--surface2);
    }

    .journey-step.done {
      background: rgba(0, 212, 170, 0.06);
    }

    .step-num {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--text-dim);
      letter-spacing: 0.1em;
    }

    .step-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 14px;
      color: var(--text);
    }

    .step-desc {
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.5;
    }

    .step-status {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      font-family: 'DM Mono', monospace;
      margin-top: 8px;
    }

    .status-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
    }

    .status-dot.done {
      background: var(--accent);
      box-shadow: 0 0 8px var(--accent);
    }

    .status-dot.active {
      background: var(--accent2);
      animation: pulse 1.5s infinite;
    }

    .status-dot.locked {
      background: var(--text-dim);
    }

    /* IMU selector */
    .imu-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 12px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .imu-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 24px 16px;
      text-align: center;
      cursor: pointer;
      transition: all 0.25s;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }

    .imu-card:hover,
    .imu-card.selected {
      border-color: var(--accent);
      background: var(--accent-dim);
    }

    .imu-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
    }

    .imu-name {
      font-family: 'Syne', sans-serif;
      font-size: 12px;
      font-weight: 700;
      color: var(--text);
      text-align: center;
      line-height: 1.3;
    }

    .imu-count {
      font-size: 11px;
      color: var(--text-muted);
      font-family: 'DM Mono', monospace;
    }

    /* ---- PHASE 1: LEARNING HUB ---- */
    .phase-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 32px;
      padding-bottom: 24px;
      border-bottom: 1px solid var(--border);
    }

    .phase-label {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--accent);
      letter-spacing: 0.12em;
      margin-bottom: 8px;
    }

    .phase-title {
      font-family: 'Syne', sans-serif;
      font-size: 28px;
      font-weight: 800;
      color: var(--text);
    }

    .readiness-pill {
      background: var(--surface);
      border: 1px solid var(--border-bright);
      border-radius: var(--radius);
      padding: 16px 24px;
      text-align: right;
    }

    .readiness-score {
      font-family: 'DM Mono', monospace;
      font-size: 32px;
      font-weight: 500;
      color: var(--warn);
    }

    .readiness-label {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 2px;
    }

    .modules-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 32px;
    }

    .module-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      cursor: pointer;
      transition: all 0.25s;
    }

    .module-card:hover {
      border-color: var(--border-bright);
      transform: translateY(-2px);
    }

    .module-card.completed {
      border-color: rgba(0, 212, 170, 0.3);
    }

    .module-top {
      height: 6px;
      background: var(--border);
    }

    .module-top .bar {
      height: 100%;
      background: var(--accent);
      border-radius: 0 3px 3px 0;
      transition: width 1s ease;
    }

    .module-body {
      padding: 20px;
    }

    .module-tag {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--accent2);
      letter-spacing: 0.1em;
      margin-bottom: 10px;
      background: var(--accent2-dim);
      display: inline-block;
      padding: 3px 8px;
      border-radius: 4px;
    }

    .module-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 14px;
      color: var(--text);
      margin-bottom: 8px;
      line-height: 1.4;
    }

    .module-meta {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 11px;
      color: var(--text-muted);
      font-family: 'DM Mono', monospace;
      margin-top: 12px;
    }

    .module-locked {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      color: var(--text-dim);
      padding: 20px;
      background: rgba(0, 0, 0, 0.2);
      border-top: 1px solid var(--border);
    }

    /* QUIZ */
    .quiz-card {
      background: var(--surface);
      border: 1px solid var(--border-bright);
      border-radius: var(--radius);
      padding: 32px;
      margin-bottom: 24px;
    }

    .quiz-scenario {
      background: rgba(61, 139, 255, 0.07);
      border: 1px solid rgba(61, 139, 255, 0.2);
      border-radius: var(--radius-sm);
      padding: 16px 20px;
      margin-bottom: 24px;
      font-size: 14px;
      line-height: 1.7;
      color: var(--text);
    }

    .quiz-scenario-label {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--accent2);
      letter-spacing: 0.12em;
      margin-bottom: 8px;
    }

    .quiz-options {
      display: grid;
      gap: 10px;
    }

    .quiz-opt {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      padding: 14px 18px;
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      cursor: pointer;
      transition: all 0.2s;
      font-size: 13px;
      color: var(--text-muted);
    }

    .quiz-opt:hover {
      border-color: var(--border-bright);
      color: var(--text);
    }

    .quiz-opt.selected {
      border-color: var(--accent);
      color: var(--text);
      background: var(--accent-dim);
    }

    .quiz-opt.correct {
      border-color: var(--accent);
      background: var(--accent-dim);
      color: var(--accent);
    }

    .quiz-opt.wrong {
      border-color: var(--danger);
      background: var(--danger-dim);
      color: var(--danger);
    }

    .opt-circle {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 1.5px solid var(--border-bright);
      flex-shrink: 0;
      margin-top: 1px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: 700;
      font-family: 'DM Mono', monospace;
    }

    /* ---- PHASE 2: SIMULATOR ---- */
    .sim-layout {
      display: grid;
      grid-template-columns: 320px 1fr 280px;
      gap: 20px;
      height: calc(100vh - 120px);
    }

    .sim-panel {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .sim-panel-header {
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .sim-panel-title {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--text-muted);
      letter-spacing: 0.1em;
    }

    /* PERSONA CARD */
    .persona-visual {
      padding: 24px 20px;
      border-bottom: 1px solid var(--border);
      position: relative;
      overflow: hidden;
    }

    .persona-visual::before {
      content: '';
      position: absolute;
      top: -30px;
      right: -30px;
      width: 120px;
      height: 120px;
      background: radial-gradient(circle, rgba(61, 139, 255, 0.15) 0%, transparent 70%);
      pointer-events: none;
    }

    .persona-avatar {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      background: linear-gradient(135deg, #1a2b4a, #2d4b7a);
      border: 2px solid rgba(61, 139, 255, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 20px;
      color: var(--accent2);
      margin-bottom: 14px;
    }

    .persona-name {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 16px;
      color: var(--text);
      margin-bottom: 4px;
    }

    .persona-role {
      font-size: 12px;
      color: var(--text-muted);
      margin-bottom: 12px;
    }

    .persona-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }

    .persona-tag {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      padding: 3px 8px;
      border-radius: 4px;
      border: 1px solid var(--border-bright);
      color: var(--text-muted);
    }

    /* TRUST INDEX */
    .ti-section {
      padding: 20px;
      border-bottom: 1px solid var(--border);
    }

    .ti-label {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      margin-bottom: 12px;
    }

    .ti-title {
      font-family: 'DM Mono', monospace;
      font-size: 10px;
      color: var(--text-muted);
      letter-spacing: 0.1em;
    }

    .ti-value {
      font-family: 'DM Mono', monospace;
      font-size: 24px;
      font-weight: 500;
    }

    .ti-value.low {
      color: var(--danger);
    }

    .ti-value.mid {
      color: var(--warn);
    }

    .ti-value.high {
      color: var(--accent);
    }

    .ti-bar-track {
      height: 8px;
      background: var(--border);
      border-radius: 4px;
      overflow: visible;
      position: relative;
      margin-bottom: 8px;
    }

    .ti-bar-fill {
      height: 100%;
      border-radius: 4px;
      transition: width 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
    }

    .ti-bar-fill.low {
      background: linear-gradient(90deg, var(--danger), #ff8099);
    }

    .ti-bar-fill.mid {
      background: linear-gradient(90deg, var(--warn), #ffd080);
    }

    .ti-bar-fill.high {
      background: linear-gradient(90deg, var(--accent), #80ffe8);
    }

    .ti-glow {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 12px;
      height: 12px;
      border-radius: 50%;
    }

    .ti-glow.high {
      background: var(--accent);
      box-shadow: 0 0 12px var(--accent);
    }

    .ti-glow.mid {
      background: var(--warn);
      box-shadow: 0 0 12px var(--warn);
    }

    .ti-glow.low {
      background: var(--danger);
      box-shadow: 0 0 12px var(--danger);
    }

    .ti-thresholds {
      display: flex;
      justify-content: space-between;
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--text-dim);
      margin-top: 6px;
    }

    .threshold-mark {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
      font-size: 9px;
    }

    .threshold-mark span:first-child {
      color: var(--text-muted);
      font-size: 10px;
    }

    /* LIVE METRICS */
    .metrics-section {
      padding: 16px 20px;
      flex: 1;
      overflow-y: auto;
    }

    .metric-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid var(--border);
    }

    .metric-row:last-child {
      border-bottom: none;
    }

    .metric-name {
      font-size: 12px;
      color: var(--text-muted);
    }

    .metric-bar-mini {
      flex: 1;
      height: 3px;
      background: var(--border);
      border-radius: 2px;
      margin: 0 12px;
      overflow: hidden;
    }

    .metric-bar-inner {
      height: 100%;
      background: var(--accent2);
      border-radius: 2px;
    }

    .metric-pct {
      font-family: 'DM Mono', monospace;
      font-size: 12px;
      color: var(--text);
      min-width: 32px;
      text-align: right;
    }

    /* CHAT AREA */
    .chat-area {
      flex: 1;
      overflow-y: auto;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      scroll-behavior: smooth;
    }

    .chat-area::-webkit-scrollbar {
      width: 4px;
    }

    .chat-area::-webkit-scrollbar-track {
      background: transparent;
    }

    .chat-area::-webkit-scrollbar-thumb {
      background: var(--border-bright);
      border-radius: 2px;
    }

    .msg {
      max-width: 85%;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .msg.user {
      align-self: flex-end;
      align-items: flex-end;
    }

    .msg.client {
      align-self: flex-start;
      align-items: flex-start;
    }

    .msg-sender {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--text-dim);
      letter-spacing: 0.08em;
    }

    .msg-bubble {
      padding: 12px 16px;
      border-radius: 12px;
      font-size: 13px;
      line-height: 1.6;
    }

    .msg.client .msg-bubble {
      background: var(--surface2);
      border: 1px solid var(--border);
      color: var(--text);
      border-radius: 4px 12px 12px 12px;
    }

    .msg.user .msg-bubble {
      background: rgba(0, 212, 170, 0.12);
      border: 1px solid rgba(0, 212, 170, 0.2);
      color: var(--text);
      border-radius: 12px 4px 12px 12px;
    }

    .msg-annotation {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 10px;
      font-family: 'DM Mono', monospace;
    }

    .annotation-chip {
      padding: 2px 8px;
      border-radius: 99px;
      font-size: 10px;
    }

    .annotation-chip.good {
      background: var(--accent-dim);
      color: var(--accent);
      border: 1px solid rgba(0, 212, 170, 0.2);
    }

    .annotation-chip.bad {
      background: var(--danger-dim);
      color: var(--danger);
      border: 1px solid rgba(255, 77, 109, 0.2);
    }

    .annotation-chip.neutral {
      background: var(--surface2);
      color: var(--text-muted);
      border: 1px solid var(--border);
    }

    .ti-event {
      align-self: center;
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 99px;
      padding: 6px 14px;
      font-size: 11px;
      font-family: 'DM Mono', monospace;
      color: var(--text-muted);
    }

    .ti-delta {
      font-weight: 500;
    }

    .ti-delta.up {
      color: var(--accent);
    }

    .ti-delta.down {
      color: var(--danger);
    }

    /* INPUT AREA */
    .chat-input-wrap {
      padding: 16px 20px;
      border-top: 1px solid var(--border);
      display: flex;
      gap: 10px;
      align-items: flex-end;
    }

    .chat-input {
      flex: 1;
      background: var(--surface2);
      border: 1px solid var(--border-bright);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      color: var(--text);
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      resize: none;
      outline: none;
      min-height: 44px;
      max-height: 120px;
      line-height: 1.5;
      transition: border-color 0.2s;
    }

    .chat-input:focus {
      border-color: rgba(0, 212, 170, 0.4);
    }

    .chat-input::placeholder {
      color: var(--text-dim);
    }

    .send-btn {
      width: 44px;
      height: 44px;
      background: var(--accent);
      border: none;
      border-radius: var(--radius-sm);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: all 0.2s;
    }

    .send-btn:hover {
      background: #00b899;
      transform: scale(1.05);
    }

    .send-btn svg {
      width: 16px;
      height: 16px;
      fill: var(--bg);
    }

    /* RIGHT PANEL: HINTS & CONTEXT */
    .hint-section {
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
      flex-shrink: 0;
    }

    .hint-title {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      color: var(--text-muted);
      letter-spacing: 0.1em;
      margin-bottom: 12px;
    }

    .hint-card {
      background: rgba(255, 184, 48, 0.06);
      border: 1px solid rgba(255, 184, 48, 0.2);
      border-radius: var(--radius-sm);
      padding: 12px 14px;
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 8px;
    }

    .hint-card strong {
      color: var(--warn);
      font-weight: 500;
    }

    .pain-points {
      padding: 16px 20px;
      flex-shrink: 0;
      border-bottom: 1px solid var(--border);
    }

    .pain-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      padding: 8px 0;
      border-bottom: 1px solid var(--border);
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.5;
    }

    .pain-item:last-child {
      border-bottom: none;
    }

    .pain-dot {
      width: 6px;
      height: 6px;
      background: var(--danger);
      border-radius: 50%;
      margin-top: 5px;
      flex-shrink: 0;
    }

    .pain-dot.discovered {
      background: var(--accent);
    }

    .timer-display {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--warn);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    /* ---- PHASE 3: FEEDBACK ---- */
    .feedback-layout {
      display: grid;
      grid-template-columns: 1fr 380px;
      gap: 24px;
    }

    .score-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 28px;
      margin-bottom: 20px;
    }

    .score-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }

    .score-big {
      font-family: 'Syne', sans-serif;
      font-size: 64px;
      font-weight: 800;
      line-height: 1;
    }

    .score-grade {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 4px;
      letter-spacing: 0.1em;
    }

    .result-badge {
      padding: 10px 20px;
      border-radius: var(--radius-sm);
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 14px;
      text-align: center;
    }

    .result-badge.breakthrough {
      background: var(--accent-dim);
      border: 1px solid rgba(0, 212, 170, 0.3);
      color: var(--accent);
    }

    .result-badge.churn {
      background: var(--danger-dim);
      border: 1px solid rgba(255, 77, 109, 0.3);
      color: var(--danger);
    }

    /* TI Timeline */
    .ti-timeline {
      position: relative;
      height: 100px;
      background: var(--surface2);
      border-radius: var(--radius-sm);
      overflow: hidden;
      margin: 20px 0;
      padding: 12px;
    }

    .ti-line {
      position: absolute;
      bottom: 12px;
      left: 12px;
      right: 12px;
      height: 60px;
    }

    .ti-sparkline {
      width: 100%;
      height: 100%;
    }

    .ti-event-markers {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: flex-end;
      gap: 0;
      padding: 12px;
    }

    /* Breakdown metrics */
    .breakdown-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-top: 20px;
    }

    .metric-block {
      background: var(--surface2);
      border-radius: var(--radius-sm);
      padding: 16px;
      border: 1px solid var(--border);
    }

    .metric-block-label {
      font-size: 11px;
      color: var(--text-muted);
      margin-bottom: 8px;
    }

    .metric-block-score {
      font-family: 'Syne', sans-serif;
      font-size: 28px;
      font-weight: 800;
    }

    .metric-block-score.good {
      color: var(--accent);
    }

    .metric-block-score.ok {
      color: var(--warn);
    }

    .metric-block-score.bad {
      color: var(--danger);
    }

    .metric-block-bar {
      height: 3px;
      background: var(--border);
      border-radius: 2px;
      margin-top: 8px;
      overflow: hidden;
    }

    .metric-block-fill {
      height: 100%;
      border-radius: 2px;
    }

    .metric-block-fill.good {
      background: var(--accent);
    }

    .metric-block-fill.ok {
      background: var(--warn);
    }

    .metric-block-fill.bad {
      background: var(--danger);
    }

    /* Redo cards */
    .redo-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      margin-bottom: 16px;
    }

    .redo-original {
      padding: 16px 20px;
      background: var(--danger-dim);
      border-bottom: 1px solid rgba(255, 77, 109, 0.15);
    }

    .redo-label {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      letter-spacing: 0.1em;
      margin-bottom: 8px;
    }

    .redo-label.bad {
      color: var(--danger);
    }

    .redo-label.good {
      color: var(--accent);
    }

    .redo-text {
      font-size: 13px;
      color: var(--text);
      line-height: 1.6;
      font-style: italic;
    }

    .redo-better {
      padding: 16px 20px;
      background: var(--accent-dim);
    }

    /* ---- PHASE 4: ANALYTICS ---- */
    .analytics-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 28px;
    }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 20px;
    }

    .stat-label {
      font-size: 11px;
      color: var(--text-muted);
      font-family: 'DM Mono', monospace;
      letter-spacing: 0.08em;
      margin-bottom: 10px;
    }

    .stat-value {
      font-family: 'Syne', sans-serif;
      font-size: 32px;
      font-weight: 800;
      color: var(--text);
      line-height: 1;
    }

    .stat-delta {
      font-size: 11px;
      margin-top: 6px;
      font-family: 'DM Mono', monospace;
    }

    .stat-delta.up {
      color: var(--accent);
    }

    .stat-delta.down {
      color: var(--danger);
    }

    .leaderboard {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
    }

    .lb-header {
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .lb-row {
      display: grid;
      grid-template-columns: 32px 1fr 80px 80px 80px;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      border-bottom: 1px solid var(--border);
      font-size: 13px;
      transition: background 0.15s;
    }

    .lb-row:hover {
      background: var(--surface2);
    }

    .lb-row:last-child {
      border-bottom: none;
    }

    .lb-row.me {
      background: var(--accent-dim);
      border-color: rgba(0, 212, 170, 0.2);
    }

    .lb-rank {
      font-family: 'DM Mono', monospace;
      font-size: 12px;
      color: var(--text-dim);
      text-align: center;
    }

    .lb-rank.top {
      color: var(--warn);
    }

    .lb-name {
      color: var(--text);
      font-weight: 500;
    }

    .lb-me-label {
      font-size: 10px;
      background: var(--accent-dim);
      color: var(--accent);
      border: 1px solid rgba(0, 212, 170, 0.2);
      padding: 2px 6px;
      border-radius: 4px;
      font-family: 'DM Mono', monospace;
    }

    .lb-score {
      font-family: 'DM Mono', monospace;
      font-size: 13px;
      text-align: center;
    }

    .cert-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-top: 24px;
    }

    .cert-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 24px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 12px;
      cursor: pointer;
      transition: all 0.25s;
    }

    .cert-card:hover {
      border-color: var(--border-bright);
      transform: translateY(-2px);
    }

    .cert-card.earned {
      border-color: rgba(0, 212, 170, 0.3);
    }

    .cert-icon {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .cert-icon.earned {
      background: var(--accent-dim);
      border: 2px solid rgba(0, 212, 170, 0.3);
    }

    .cert-icon.locked {
      background: var(--surface2);
      border: 2px solid var(--border);
      filter: grayscale(1);
      opacity: 0.5;
    }

    .cert-name {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 13px;
      color: var(--text);
    }

    .cert-desc {
      font-size: 11px;
      color: var(--text-muted);
      line-height: 1.5;
    }

    /* UTILITY */
    .section-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 18px;
      color: var(--text);
      margin-bottom: 16px;
    }

    .section-sub {
      font-size: 13px;
      color: var(--text-muted);
      margin-bottom: 20px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: var(--radius-sm);
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      border: none;
      transition: all 0.2s;
      text-decoration: none;
    }

    .btn-primary {
      background: var(--accent);
      color: var(--bg);
    }

    .btn-primary:hover {
      background: #00b899;
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: var(--surface2);
      color: var(--text);
      border: 1px solid var(--border-bright);
    }

    .btn-secondary:hover {
      border-color: var(--accent);
      color: var(--accent);
    }

    .btn-danger {
      background: var(--danger-dim);
      color: var(--danger);
      border: 1px solid rgba(255, 77, 109, 0.2);
    }

    .divider {
      height: 1px;
      background: var(--border);
      margin: 24px 0;
    }

    .tag {
      font-size: 10px;
      font-family: 'DM Mono', monospace;
      padding: 3px 8px;
      border-radius: 4px;
    }

    .tag-green {
      background: var(--accent-dim);
      color: var(--accent);
      border: 1px solid rgba(0, 212, 170, 0.2);
    }

    .tag-blue {
      background: var(--accent2-dim);
      color: var(--accent2);
      border: 1px solid rgba(61, 139, 255, 0.2);
    }

    .tag-warn {
      background: var(--warn-dim);
      color: var(--warn);
      border: 1px solid rgba(255, 184, 48, 0.2);
    }

    .tag-danger {
      background: var(--danger-dim);
      color: var(--danger);
      border: 1px solid rgba(255, 77, 109, 0.2);
    }

    .flex {
      display: flex;
    }

    .flex-col {
      flex-direction: column;
    }

    .items-center {
      align-items: center;
    }

    .justify-between {
      justify-content: space-between;
    }

    .gap-8 {
      gap: 8px;
    }

    .gap-12 {
      gap: 12px;
    }

    .gap-16 {
      gap: 16px;
    }

    .mt-8 {
      margin-top: 8px;
    }

    .mt-16 {
      margin-top: 16px;
    }

    .mb-16 {
      margin-bottom: 16px;
    }

    .mb-24 {
      margin-bottom: 24px;
    }

    .text-sm {
      font-size: 12px;
    }

    .text-muted {
      color: var(--text-muted);
    }

    .mono {
      font-family: 'DM Mono', monospace;
    }

    /* Scrollbar global */
    ::-webkit-scrollbar {
      width: 4px;
      height: 4px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--border-bright);
      border-radius: 2px;
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(8px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .page.active {
      animation: fadeIn 0.3s ease;
    }

    .ti-value {
      transition: color 0.5s;
    }

    /* Typing indicator */
    .typing-dots {
      display: flex;
      gap: 4px;
      padding: 10px 14px;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 4px 12px 12px 12px;
      width: fit-content;
    }

    .typing-dot {
      width: 6px;
      height: 6px;
      background: var(--text-dim);
      border-radius: 50%;
      animation: bounce 1.2s ease-in-out infinite;
    }

    .typing-dot:nth-child(2) {
      animation-delay: 0.2s;
    }

    .typing-dot:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes bounce {

      0%,
      80%,
      100% {
        transform: translateY(0);
      }

      40% {
        transform: translateY(-6px);
        background: var(--text-muted);
      }
    }

    /* Alert banner */
    .alert-bar {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      border-radius: var(--radius-sm);
      margin-bottom: 16px;
      font-size: 13px;
      border: 1px solid;
    }

    .alert-bar.breakthrough {
      background: var(--accent-dim);
      border-color: rgba(0, 212, 170, 0.3);
      color: var(--accent);
    }

    .alert-bar.warning {
      background: var(--danger-dim);
      border-color: rgba(255, 77, 109, 0.3);
      color: var(--danger);
    }

    /* Audio wave bars */
    @keyframes wave {

      0%,
      100% {
        height: 4px;
      }

      50% {
        height: 20px;
      }
    }

    .wave-bar {
      width: 3px;
      height: 4px;
      border-radius: 2px;
      background: var(--accent2);
      animation: wave 0.9s ease-in-out infinite;
      animation-delay: var(--d);
      transition: background 0.3s;
    }

    .wave-bar.user {
      background: var(--accent);
      animation: wave 0.7s ease-in-out infinite;
      animation-delay: var(--d);
      height: 3px;
    }

    .wave-bar.muted {
      animation: none;
      height: 3px;
      background: var(--text-dim);
    }

    .wave-bar.idle {
      animation: none;
      height: 3px;
      background: var(--text-dim);
    }

    /* Quick frame chips */
    .qf-btn {
      font-size: 11px;
      font-family: 'DM Mono', monospace;
      padding: 5px 12px;
      border-radius: 99px;
      background: var(--surface2);
      border: 1px solid var(--border-bright);
      color: var(--text-muted);
      cursor: pointer;
      transition: all 0.2s;
      white-space: nowrap;
    }

    .qf-btn:hover {
      border-color: var(--accent);
      color: var(--accent);
    }

    .qf-btn.active {
      background: var(--accent-dim);
      border-color: rgba(0, 212, 170, 0.3);
      color: var(--accent);
    }

    /* Pulse rings animation */
    @keyframes ringPulse {

      0%,
      100% {
        transform: scale(1);
        opacity: 0.5;
      }

      50% {
        transform: scale(1.08);
        opacity: 1;
      }
    }

    .ring-active {
      animation: ringPulse 1s ease-in-out infinite !important;
      border-color: rgba(61, 139, 255, 0.5) !important;
    }

    .ring2-active {
      animation: ringPulse 1s ease-in-out 0.2s infinite !important;
      border-color: rgba(61, 139, 255, 0.25) !important;
    }

    /* Mic active glow */
    #mic-btn.active-mic {
      box-shadow: 0 0 0 0 rgba(0, 212, 170, 0.4);
      animation: micPulse 1.5s ease-in-out infinite;
    }

    @keyframes micPulse {
      0% {
        box-shadow: 0 0 0 0 rgba(0, 212, 170, 0.4);
      }

      70% {
        box-shadow: 0 0 0 14px rgba(0, 212, 170, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(0, 212, 170, 0);
      }
    }

    #mic-btn.muted-mic {
      background: var(--danger);
      box-shadow: 0 0 20px rgba(255, 77, 109, 0.3);
      animation: none;
    }


    .radial-wrap {
      position: relative;
      width: 120px;
      height: 120px;
      flex-shrink: 0;
    }

    .radial-svg {
      transform: rotate(-90deg);
    }

    .radial-center {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .radial-num {
      font-family: 'Syne', sans-serif;
      font-size: 22px;
      font-weight: 800;
      line-height: 1;
    }

    .radial-sub {
      font-size: 9px;
      font-family: 'DM Mono', monospace;
      color: var(--text-muted);
      margin-top: 2px;
    }
  </style>
</head>

<body>

  <!-- NAV -->
  <nav class="tabs-outer">
    <div class="tabs-inner">
      <div class="logo">
        <div class="logo-dot"></div>
        EXL PITCH SIM
      </div>

      <button class="tab-btn active" onclick="showPage('onboard')">
        Overview
      </button>
      <button class="tab-btn" onclick="showPage('learn')">
        Phase 1 — Learning Hub
        <span class="tab-badge">3 modules</span>
      </button>
      <button class="tab-btn" onclick="showPage('sim')">
        Phase 2 — Simulator
        <span class="tab-badge">Live</span>
      </button>
      <button class="tab-btn" onclick="showPage('feedback')">
        Phase 3 — Feedback Coach
      </button>
      <button class="tab-btn" onclick="showPage('analytics')">
        Phase 4 — Analytics
      </button>

      <div class="ml-auto">
        <div class="user-chip">
          <div class="user-avatar">RS</div>
          Rahul S. · Insurance
        </div>
      </div>
    </div>
  </nav>

  <!-- ====== PAGE: OVERVIEW ====== -->
  <div class="page active" id="page-onboard">
    <div class="onboard-hero">
      <div class="imu-label">⬡ INSURANCE · L&A · P&C</div>
      <h1 class="hero-title">Master the<br>Solutions Sale.</h1>
      <p class="hero-sub">A generative AI simulation platform for EXL sales leaders. Practice high-stakes discovery,
        objection handling, and solution pitching — before walking into the room.</p>

      <div class="journey-track">
        <div class="journey-step done" onclick="showPage('learn')">
          <div class="step-num">01 ——</div>
          <div class="step-title">Learning Hub</div>
          <div class="step-desc">Micro-learning modules on EXL solutions by IMU</div>
          <div class="step-status">
            <div class="status-dot done"></div>
            <span style="color: var(--accent); font-size:11px; font-family:'DM Mono',monospace;">COMPLETE</span>
          </div>
        </div>
        <div class="journey-step" onclick="showPage('learn')">
          <div class="step-num">01b ——</div>
          <div class="step-title">Mini Quiz</div>
          <div class="step-desc">PMF scenarios to unlock the Simulator</div>
          <div class="step-status">
            <div class="status-dot active"></div>
            <span style="color: var(--accent2); font-size:11px; font-family:'DM Mono',monospace;">IN PROGRESS</span>
          </div>
        </div>
        <div class="journey-step" onclick="showPage('sim')">
          <div class="step-num">02 ——</div>
          <div class="step-title">Simulator</div>
          <div class="step-desc">Live AI client persona with Trust Index scoring</div>
          <div class="step-status">
            <div class="status-dot locked"></div>
            <span style="color: var(--text-dim); font-size:11px; font-family:'DM Mono',monospace;">LOCKED · 78 RS</span>
          </div>
        </div>
        <div class="journey-step" onclick="showPage('feedback')">
          <div class="step-num">03 ——</div>
          <div class="step-title">Feedback Coach</div>
          <div class="step-desc">AI debrief, TI replay, redo suggestions</div>
          <div class="step-status">
            <div class="status-dot locked"></div>
            <span style="color: var(--text-dim); font-size:11px; font-family:'DM Mono',monospace;">LOCKED</span>
          </div>
        </div>
      </div>
    </div>

    <!-- IMU SELECTOR -->
    <div style="text-align:center; margin-bottom: 20px;">
      <div class="section-title">Select your IMU</div>
      <p class="section-sub">Each vertical has dedicated client personas, solution playbooks, and case studies.</p>
    </div>
    <div class="imu-grid">
      <div class="imu-card selected">
        <div class="imu-icon" style="background: rgba(0,212,170,0.1);">🏛️</div>
        <div class="imu-name">Insurance L&A</div>
        <div class="imu-count">12 scenarios</div>
      </div>
      <div class="imu-card">
        <div class="imu-icon" style="background: rgba(61,139,255,0.1);">🛡️</div>
        <div class="imu-name">Insurance P&C</div>
        <div class="imu-count">9 scenarios</div>
      </div>
      <div class="imu-card">
        <div class="imu-icon" style="background: rgba(255,184,48,0.1);">❤️</div>
        <div class="imu-name">Healthcare</div>
        <div class="imu-count">8 scenarios</div>
      </div>
      <div class="imu-card">
        <div class="imu-icon" style="background: rgba(255,77,109,0.1);">🏦</div>
        <div class="imu-name">Banking & Capital Markets</div>
        <div class="imu-count">11 scenarios</div>
      </div>
      <div class="imu-card">
        <div class="imu-icon" style="background: rgba(150,100,255,0.1);">⚙️</div>
        <div class="imu-name">Diversified Industries</div>
        <div class="imu-count">6 scenarios</div>
      </div>
    </div>
  </div>

  <!-- ====== PAGE: LEARNING HUB ====== -->
  <div class="page" id="page-learn">
    <div class="phase-header">
      <div>
        <div class="phase-label">PHASE 01 — FOUNDATION</div>
        <div class="phase-title">Learning Hub</div>
      </div>
      <div style="display:flex; gap:16px; align-items:flex-start;">
        <div class="readiness-pill">
          <div class="readiness-score">78</div>
          <div class="readiness-label">Readiness Score · Need 80 to unlock</div>
        </div>
        <div style="text-align:right;">
          <button class="btn btn-primary" onclick="showPage('sim')">Enter Simulator →</button>
          <div style="font-size:11px; color: var(--danger); margin-top: 6px; font-family:'DM Mono',monospace;">Score too
            low — complete quiz</div>
        </div>
      </div>
    </div>

    <!-- Progress Bar -->
    <div
      style="background: var(--surface); border:1px solid var(--border); border-radius: var(--radius); padding: 20px; margin-bottom: 24px;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <span style="font-size:13px; color: var(--text-muted);">Overall Progress</span>
        <span style="font-family:'DM Mono',monospace; font-size:13px; color:var(--text);">2 of 5 modules complete</span>
      </div>
      <div style="height:6px; background:var(--border); border-radius:4px; overflow:hidden;">
        <div
          style="width:40%; height:100%; background: linear-gradient(90deg, var(--accent2), var(--accent)); border-radius:4px;">
        </div>
      </div>
    </div>

    <!-- MODULES -->
    <div class="modules-grid">
      <!-- Module 1 -->
      <div class="module-card completed">
        <div class="module-top">
          <div class="bar" style="width:100%"></div>
        </div>
        <div class="module-body">
          <div class="module-tag">SOLUTIONS · L&A</div>
          <div class="module-title">EXL Insurance Digital Transformation Suite</div>
          <div style="font-size:12px; color:var(--text-muted); line-height:1.5;">Core capabilities: PAS modernization,
            servicing automation, advisor journey redesign. Key differentiators vs. legacy vendors.</div>
          <div class="module-meta">
            <span>⏱ 12 min</span>
            <span>·</span>
            <span style="color: var(--accent);">✓ Complete</span>
          </div>
        </div>
      </div>

      <!-- Module 2 -->
      <div class="module-card completed">
        <div class="module-top">
          <div class="bar" style="width:100%"></div>
        </div>
        <div class="module-body">
          <div class="module-tag">COMPLIANCE</div>
          <div class="module-title">IFRS 17 & LDTI — The Data & Controls Angle</div>
          <div style="font-size:12px; color:var(--text-muted); line-height:1.5;">Regulatory context, CFO pain points,
            EXL's actuarial data management approach. Case study: Tier-1 EU insurer.</div>
          <div class="module-meta">
            <span>⏱ 18 min</span>
            <span>·</span>
            <span style="color: var(--accent);">✓ Complete</span>
          </div>
        </div>
      </div>

      <!-- Module 3 -->
      <div class="module-card">
        <div class="module-top">
          <div class="bar" style="width:55%"></div>
        </div>
        <div class="module-body">
          <div class="module-tag">STRATEGY</div>
          <div class="module-title">Discovery & Buying Center Mapping</div>
          <div style="font-size:12px; color:var(--text-muted); line-height:1.5;">Identifying COO vs. CDO vs. CIO
            priorities. Multi-threaded deal strategy. Layer 2 question frameworks.</div>
          <div class="module-meta">
            <span>⏱ 14 min</span>
            <span>·</span>
            <span style="color: var(--warn);">55% done</span>
          </div>
        </div>
        <div class="module-locked">
          <span style="color: var(--accent2);">→</span> Resume module
        </div>
      </div>

      <!-- Module 4 -->
      <div class="module-card">
        <div class="module-top">
          <div class="bar" style="width:0%"></div>
        </div>
        <div class="module-body">
          <div class="module-tag">OBJECTIONS</div>
          <div class="module-title">Handling "We're Already with Vendor X"</div>
          <div style="font-size:12px; color:var(--text-muted); line-height:1.5;">Displacement strategy, coexistence
            positioning, total-cost-of-status-quo framing.</div>
          <div class="module-meta">
            <span>⏱ 10 min</span>
            <span>·</span>
            <span style="color: var(--text-dim);">Not started</span>
          </div>
        </div>
        <div class="module-locked">
          🔒 Complete module 3 first
        </div>
      </div>

      <!-- Module 5 -->
      <div class="module-card">
        <div class="module-top">
          <div class="bar" style="width:0%"></div>
        </div>
        <div class="module-body">
          <div class="module-tag">CASE STUDIES</div>
          <div class="module-title">EXL Wins: 5 Reference Stories by Persona</div>
          <div style="font-size:12px; color:var(--text-muted); line-height:1.5;">CFO, COO, CDO, CIO, and Chief Actuary
            win stories. Quantified ROI statements. Approved reference language.</div>
          <div class="module-meta">
            <span>⏱ 16 min</span>
            <span>·</span>
            <span style="color: var(--text-dim);">Not started</span>
          </div>
        </div>
        <div class="module-locked">
          🔒 Complete modules 3–4 first
        </div>
      </div>
    </div>

    <!-- QUIZ SECTION -->
    <div class="divider"></div>
    <div class="section-title">PMF Scenario Quiz</div>
    <p class="section-sub">Answer 5 "If-Then" scenarios to prove readiness. You need 80+ to unlock the Simulator.</p>

    <div class="quiz-card">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <span style="font-family:'DM Mono',monospace; font-size:11px; color:var(--text-muted);">SCENARIO 3 OF 5</span>
        <div style="display:flex; gap:6px;">
          <div style="width:28px; height:4px; border-radius:2px; background: var(--accent);"></div>
          <div style="width:28px; height:4px; border-radius:2px; background: var(--accent);"></div>
          <div style="width:28px; height:4px; border-radius:2px; background: var(--accent2);"></div>
          <div style="width:28px; height:4px; border-radius:2px; background: var(--border);"></div>
          <div style="width:28px; height:4px; border-radius:2px; background: var(--border);"></div>
        </div>
      </div>
      <div class="quiz-scenario">
        <div class="quiz-scenario-label">IF — CLIENT SITUATION</div>
        A multi-market EU/APAC life insurer has grown through acquisitions. Operations run on 4 fragmented PAS systems +
        manual servicing workflows. The CEO mandate: "Reduce cost-to-serve by 30% without a big-bang core replacement."
        You are in the first meeting with the <strong>COO</strong>.
      </div>
      <div style="font-size:13px; color: var(--text-muted); margin-bottom:16px; font-weight:500;">Which three EXL
        capabilities should lead your opening?</div>
      <div class="quiz-options">
        <div class="quiz-opt" onclick="selectOpt(this)">
          <div class="opt-circle">A</div>
          <div>EXL Digital Mailroom + Intelligent Servicing Automation + Advisor Portal — reduce manual touchpoints
            across fragmented systems</div>
        </div>
        <div class="quiz-opt correct" onclick="selectOpt(this)">
          <div class="opt-circle" style="border-color: var(--accent); color: var(--accent);">B</div>
          <div>EXL PAS Coexistence Layer + Workflow Orchestration + Customer Servicing Analytics — addresses
            fragmentation without rip-and-replace ✓</div>
        </div>
        <div class="quiz-opt" onclick="selectOpt(this)">
          <div class="opt-circle">C</div>
          <div>IFRS 17 Reporting Suite + Actuarial Cloud + Controls Automation — CFO-led agenda, wrong stakeholder for
            this meeting</div>
        </div>
        <div class="quiz-opt" onclick="selectOpt(this)">
          <div class="opt-circle">D</div>
          <div>Advisor Journey Redesign + AI-Underwriting + Digital Claims — growth agenda, misaligned with
            cost-reduction mandate</div>
        </div>
      </div>
      <div
        style="margin-top:20px; padding:14px 18px; background: var(--accent-dim); border:1px solid rgba(0,212,170,0.2); border-radius: var(--radius-sm);">
        <div style="font-size:10px; font-family:'DM Mono',monospace; color:var(--accent); margin-bottom:6px;">WHY B IS
          CORRECT</div>
        <div style="font-size:12px; color:var(--text-muted); line-height:1.6;">The CEO mandate is cost-to-serve
          reduction, not core replacement. The COO needs a coexistence story. Leading with IFRS 17 (C) is a CFO
          conversation. Leading with growth (D) contradicts the mandate entirely.</div>
      </div>
      <div style="display:flex; justify-content:flex-end; margin-top:20px; gap:10px;">
        <button class="btn btn-secondary">← Previous</button>
        <button class="btn btn-primary">Next Scenario →</button>
      </div>
    </div>
  </div>

  <!-- ====== PAGE: SIMULATOR ====== -->
  <div class="page" id="page-sim">
    <div class="sim-layout">
      <!-- LEFT: PERSONA + TRUST -->
      <div class="sim-panel">
        <div class="sim-panel-header">
          <span class="sim-panel-title">CLIENT PERSONA</span>
          <div class="timer-display">⏱ 23:41</div>
        </div>

        <div class="persona-visual">
          <div class="persona-avatar">MV</div>
          <div class="persona-name">Maria van der Berg</div>
          <div class="persona-role">COO · Meridian Life Holdings · Amsterdam</div>
          <div class="persona-tags">
            <span class="persona-tag">EU/APAC Operations</span>
            <span class="persona-tag">4 PAS Systems</span>
            <span class="persona-tag">Cost Mandate</span>
            <span class="persona-tag">Skeptical Buyer</span>
          </div>
        </div>

        <!-- TRUST INDEX -->
        <div class="ti-section">
          <div class="ti-label">
            <span class="ti-title">TRUST INDEX (Ti)</span>
            <span class="ti-value high" id="ti-val">72</span>
          </div>
          <div class="ti-bar-track">
            <div class="ti-bar-fill high" id="ti-bar" style="width:72%">
              <div class="ti-glow high"></div>
            </div>
          </div>
          <div class="ti-thresholds">
            <div class="threshold-mark">
              <span>0</span>
              <span style="color:var(--danger);">Churn</span>
            </div>
            <div class="threshold-mark">
              <span style="color:var(--danger);">40</span>
              <span>Danger</span>
            </div>
            <div class="threshold-mark">
              <span style="color:var(--warn);">60</span>
              <span>Baseline</span>
            </div>
            <div class="threshold-mark">
              <span style="color:var(--accent);">80</span>
              <span>Unlock</span>
            </div>
            <div class="threshold-mark">
              <span style="color:var(--accent);">100</span>
              <span>Close</span>
            </div>
          </div>

          <div style="margin-top:16px; display:flex; gap:8px; flex-wrap:wrap;">
            <span class="tag tag-green">+5 Empathy</span>
            <span class="tag tag-warn">−3 Premature pitch</span>
            <span class="tag tag-blue">+8 Case study cited</span>
          </div>
        </div>

        <!-- LIVE METRICS -->
        <div class="metrics-section">
          <div class="hint-title">LIVE SCORING</div>
          <div class="metric-row">
            <div class="metric-name">Mirroring & Empathy</div>
            <div class="metric-bar-mini">
              <div class="metric-bar-inner" style="width:68%; background:var(--accent);"></div>
            </div>
            <div class="metric-pct" style="color:var(--accent);">68%</div>
          </div>
          <div class="metric-row">
            <div class="metric-name">Consultative Inquiry</div>
            <div class="metric-bar-mini">
              <div class="metric-bar-inner" style="width:52%;background:var(--warn);"></div>
            </div>
            <div class="metric-pct" style="color:var(--warn);">52%</div>
          </div>
          <div class="metric-row">
            <div class="metric-name">Factual Assurances</div>
            <div class="metric-bar-mini">
              <div class="metric-bar-inner" style="width:80%;background:var(--accent);"></div>
            </div>
            <div class="metric-pct" style="color:var(--accent);">80%</div>
          </div>
          <div class="metric-row">
            <div class="metric-name">Solution Fit Relevance</div>
            <div class="metric-bar-mini">
              <div class="metric-bar-inner" style="width:44%;background:var(--danger);"></div>
            </div>
            <div class="metric-pct" style="color:var(--danger);">44%</div>
          </div>
          <div class="metric-row">
            <div class="metric-name">Deal Stage Awareness</div>
            <div class="metric-bar-mini">
              <div class="metric-bar-inner" style="width:61%;background:var(--accent2);"></div>
            </div>
            <div class="metric-pct" style="color:var(--accent2);">61%</div>
          </div>
        </div>
      </div>

      <!-- CENTER: AUDIO CALL -->
      <div class="sim-panel" style="display:flex; flex-direction:column;">
        <div class="sim-panel-header">
          <div style="display:flex; align-items:center; gap:10px;">
            <div
              style="width:8px;height:8px;border-radius:50%;background:var(--accent);box-shadow:0 0 8px var(--accent);animation:pulse 1.5s infinite;">
            </div>
            <span class="sim-panel-title">LIVE CALL — Insurance L&A · Scenario 3</span>
          </div>
          <div style="display:flex; gap:8px; align-items:center;">
            <div class="timer-display" id="call-timer">⏱ 04:12</div>
            <button class="btn btn-secondary" style="font-size:11px; padding:6px 12px;" onclick="togglePause()">⏸
              Pause</button>
            <button class="btn btn-danger" style="font-size:11px; padding:6px 12px;" onclick="endCall()">End
              Call</button>
          </div>
        </div>

        <!-- Alert bar -->
        <div style="padding: 0 16px; margin-top:12px;" id="alert-bar-wrap">
          <div class="alert-bar breakthrough">
            <span>🎯</span>
            <span><strong>Ti approaching Breakthrough (80).</strong> Ask a Layer 2 question to unlock formal pitch
              request.</span>
          </div>
        </div>

        <!-- CALL STAGE: pre-call -->
        <div id="call-stage-pre"
          style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:32px; gap:24px;">
          <div
            style="width:88px; height:88px; border-radius:22px; background:linear-gradient(135deg,#1a2b4a,#2d4b7a); border:2px solid rgba(61,139,255,0.3); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:28px; color:var(--accent2);">
            MV</div>
          <div style="text-align:center;">
            <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:18px;">Maria van der Berg</div>
            <div style="font-size:13px; color:var(--text-muted); margin-top:4px;">COO · Meridian Life Holdings</div>
          </div>
          <div style="font-size:13px; color:var(--text-muted); text-align:center; max-width:280px; line-height:1.6;">
            You're about to join a live simulation call. Speak naturally — the AI will respond in real time.</div>
          <button class="btn btn-primary" style="padding:14px 40px; font-size:14px; border-radius:99px;"
            onclick="startCall()">
            📞 Start Call
          </button>
        </div>

        <!-- CALL STAGE: active -->
        <div id="call-stage-active" style="display:none; flex:1; flex-direction:column; overflow:hidden;">

          <!-- AVATAR + WAVEFORM AREA -->
          <div
            style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:20px; gap:20px; position:relative;">

            <!-- Client speaking indicator -->
            <div id="client-speaking-ring" style="position:relative; width:110px; height:110px;">
              <!-- Outer pulse rings -->
              <div id="ring1"
                style="position:absolute; inset:-12px; border-radius:50%; border:2px solid rgba(61,139,255,0.15); transition:all 0.3s;">
              </div>
              <div id="ring2"
                style="position:absolute; inset:-24px; border-radius:50%; border:1.5px solid rgba(61,139,255,0.08); transition:all 0.3s;">
              </div>
              <!-- Avatar -->
              <div
                style="width:110px; height:110px; border-radius:26px; background:linear-gradient(135deg,#1a2b4a,#2d4b7a); border:2px solid rgba(61,139,255,0.4); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:34px; color:var(--accent2); position:relative; z-index:1;">
                MV</div>
              <!-- Speaking badge -->
              <div id="speaking-badge"
                style="position:absolute; bottom:-8px; left:50%; transform:translateX(-50%); background:var(--accent2); color:var(--bg); font-size:10px; font-family:'DM Mono',monospace; padding:3px 10px; border-radius:99px; white-space:nowrap; z-index:2; opacity:0; transition:opacity 0.3s;">
                speaking...</div>
            </div>

            <div style="text-align:center;">
              <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:16px;">Maria van der Berg</div>
              <div style="font-size:12px; color:var(--text-muted); margin-top:3px;">COO · Meridian Life Holdings ·
                Amsterdam</div>
            </div>

            <!-- Live transcript strip -->
            <div
              style="width:100%; background:var(--surface2); border:1px solid var(--border); border-radius:var(--radius-sm); padding:14px 16px; min-height:72px; position:relative; overflow:hidden;">
              <div
                style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim); margin-bottom:8px; letter-spacing:0.08em;">
                LIVE TRANSCRIPT</div>
              <div id="live-transcript" style="font-size:13px; color:var(--text); line-height:1.6; min-height:40px;">
                <span id="transcript-text" style="color:var(--text-muted); font-style:italic;">Waiting for
                  speech...</span>
              </div>
              <!-- Scroll gradient -->
              <div
                style="position:absolute; bottom:0; left:0; right:0; height:20px; background:linear-gradient(transparent, var(--surface2)); pointer-events:none;">
              </div>
            </div>

            <!-- Client audio waveform (animated bars) -->
            <div id="client-waveform"
              style="display:flex; align-items:center; gap:3px; height:32px; opacity:0; transition:opacity 0.3s;">
              <div class="wave-bar" style="--d:0s"></div>
              <div class="wave-bar" style="--d:0.1s"></div>
              <div class="wave-bar" style="--d:0.2s"></div>
              <div class="wave-bar" style="--d:0.05s"></div>
              <div class="wave-bar" style="--d:0.15s"></div>
              <div class="wave-bar" style="--d:0.25s"></div>
              <div class="wave-bar" style="--d:0.08s"></div>
              <div class="wave-bar" style="--d:0.18s"></div>
              <div class="wave-bar" style="--d:0.12s"></div>
              <div class="wave-bar" style="--d:0.22s"></div>
              <div class="wave-bar" style="--d:0.06s"></div>
              <div class="wave-bar" style="--d:0.16s"></div>
            </div>

            <!-- Turn events log -->
            <div id="turn-log"
              style="width:100%; display:flex; flex-direction:column; gap:6px; max-height:80px; overflow-y:auto;">
              <div class="ti-event" style="font-size:11px;">
                <span>Ti</span><span class="ti-delta up">▲ +6 → 66</span><span
                  style="color:var(--text-dim);">Coexistence framing resonated</span>
              </div>
              <div class="ti-event" style="font-size:11px;">
                <span>Ti</span><span class="ti-delta up">▲ +8 → 72</span><span style="color:var(--text-dim);">Layer 2
                  question · breakthrough approaching</span>
              </div>
            </div>
          </div>

          <!-- YOUR MIC AREA -->
          <div
            style="border-top:1px solid var(--border); padding:20px; display:flex; flex-direction:column; gap:14px; flex-shrink:0;">

            <!-- User waveform + status -->
            <div style="display:flex; align-items:center; gap:16px;">
              <div id="user-avatar-call"
                style="width:40px; height:40px; border-radius:10px; background:var(--accent-dim); border:1.5px solid rgba(0,212,170,0.3); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:14px; color:var(--accent); flex-shrink:0;">
                RS</div>
              <div style="flex:1;">
                <div id="mic-status-label"
                  style="font-size:11px; font-family:'DM Mono',monospace; color:var(--text-dim); margin-bottom:6px; letter-spacing:0.08em;">
                  YOUR MIC · LISTENING</div>
                <!-- User waveform bars -->
                <div id="user-waveform" style="display:flex; align-items:center; gap:3px; height:24px;">
                  <div class="wave-bar user" style="--d:0s"></div>
                  <div class="wave-bar user" style="--d:0.07s"></div>
                  <div class="wave-bar user" style="--d:0.14s"></div>
                  <div class="wave-bar user" style="--d:0.21s"></div>
                  <div class="wave-bar user" style="--d:0.05s"></div>
                  <div class="wave-bar user" style="--d:0.12s"></div>
                  <div class="wave-bar user" style="--d:0.19s"></div>
                  <div class="wave-bar user" style="--d:0.09s"></div>
                  <div class="wave-bar user" style="--d:0.17s"></div>
                  <div class="wave-bar user" style="--d:0.03s"></div>
                  <div class="wave-bar user" style="--d:0.11s"></div>
                  <div class="wave-bar user" style="--d:0.16s"></div>
                </div>
              </div>
              <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                <div id="ai-coach-chip"
                  style="background:var(--warn-dim); border:1px solid rgba(255,184,48,0.25); border-radius:99px; padding:4px 10px; font-size:10px; font-family:'DM Mono',monospace; color:var(--warn); white-space:nowrap;">
                  🧠 Coach ON</div>
              </div>
            </div>

            <!-- CONTROLS ROW -->
            <div style="display:flex; align-items:center; gap:10px;">
              <!-- Big mic button -->
              <button id="mic-btn" onclick="toggleMic()"
                style="width:56px; height:56px; border-radius:50%; background:var(--accent); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s; flex-shrink:0; box-shadow: 0 0 20px rgba(0,212,170,0.3);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#080c14" stroke-width="2.5"
                  stroke-linecap="round">
                  <rect x="9" y="2" width="6" height="12" rx="3" />
                  <path d="M5 10a7 7 0 0 0 14 0" />
                  <line x1="12" y1="19" x2="12" y2="22" />
                  <line x1="8" y1="22" x2="16" y2="22" />
                </svg>
              </button>

              <!-- Mute / Volume / Coach toggle -->
              <button id="mute-btn" onclick="toggleMute()" title="Mute"
                style="width:40px;height:40px;border-radius:50%;background:var(--surface2);border:1px solid var(--border-bright);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"
                  stroke-linecap="round">
                  <path d="M11 5L6 9H2v6h4l5 4V5z" />
                  <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07" />
                </svg>
              </button>

              <button onclick="toggleCoach()" title="Toggle coach hints"
                style="width:40px;height:40px;border-radius:50%;background:var(--surface2);border:1px solid var(--border-bright);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;"
                id="coach-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--warn)" stroke-width="2"
                  stroke-linecap="round">
                  <circle cx="12" cy="12" r="10" />
                  <path d="M12 16v-4M12 8h.01" />
                </svg>
              </button>

              <div
                style="flex:1; background:var(--surface2); border:1px solid var(--border); border-radius:var(--radius-sm); padding:8px 14px; font-size:12px; color:var(--text-muted); font-style:italic; font-family:'Inter',sans-serif;"
                id="coach-whisper">
                💬 Try a Layer 2 question — ask what's driving the advisor contact issue specifically.
              </div>
            </div>

            <!-- Quick reply chips (voice shortcuts) -->
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
              <div
                style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim); align-self:center; margin-right:4px;">
                QUICK FRAME:</div>
              <button onclick="useQuickFrame(this)" class="qf-btn">Acknowledge pain</button>
              <button onclick="useQuickFrame(this)" class="qf-btn">Ask Layer 2</button>
              <button onclick="useQuickFrame(this)" class="qf-btn">Cite case study</button>
              <button onclick="useQuickFrame(this)" class="qf-btn">Coexistence angle</button>
            </div>
          </div>
        </div>

        <!-- CALL STAGE: ended -->
        <div id="call-stage-ended"
          style="display:none; flex:1; align-items:center; justify-content:center; flex-direction:column; gap:20px; padding:40px; text-align:center;">
          <div style="font-size:48px;">📋</div>
          <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:20px;">Call Complete</div>
          <div style="font-size:13px; color:var(--text-muted); max-width:260px; line-height:1.6;">Session lasted 04:12 ·
            6 speaking turns · Ti peaked at 82</div>
          <button class="btn btn-primary" onclick="showPage('feedback')"
            style="border-radius:99px; padding:12px 32px;">View Feedback Coach →</button>
        </div>
      </div>

      <!-- RIGHT: HINTS + CONTEXT -->
      <div class="sim-panel">
        <div class="sim-panel-header">
          <span class="sim-panel-title">COACH HINTS</span>
          <span class="tag tag-warn" style="font-size:10px;">LIVE</span>
        </div>

        <div class="hint-section">
          <div class="hint-title">NEXT MOVE SUGGESTION</div>
          <div class="hint-card">
            <strong>Layer 2 opportunity:</strong> She revealed advisor productivity as the real pain. Ask whether the
            issue is <strong>data visibility</strong> or <strong>inbound query routing</strong> — this determines which
            EXL module leads.
          </div>
          <div class="hint-card" style="background: rgba(61,139,255,0.06); border-color: rgba(61,139,255,0.2);">
            <strong style="color:var(--accent2);">Relevant case study:</strong> Cite the Tier-1 EU insurer that reduced
            advisor contact rate by 38% using EXL's Intelligent Servicing Hub — without replacing their legacy PAS.
          </div>
        </div>

        <div class="pain-points">
          <div class="hint-title">HIDDEN PAIN POINTS</div>
          <div class="pain-item">
            <div class="pain-dot discovered"></div>
            <div>Advisor productivity — 40% time on manual status updates <span class="tag tag-green"
                style="margin-left:4px;">Discovered</span></div>
          </div>
          <div class="pain-item">
            <div class="pain-dot"></div>
            <div>Customer contact volumes — inbound queries overwhelming servicing team</div>
          </div>
          <div class="pain-item">
            <div class="pain-dot"></div>
            <div>API limitations in legacy PAS preventing real-time data access</div>
          </div>
          <div class="pain-item">
            <div class="pain-dot"></div>
            <div>CDO mandate for unified data layer — shadow IT proliferation</div>
          </div>
        </div>

        <div style="padding: 16px 20px; flex:1; overflow-y:auto;">
          <div class="hint-title">BUYING CENTER STATUS</div>
          <div style="display:flex; flex-direction:column; gap:8px; margin-top:8px;">
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px;">
              <span style="color:var(--text-muted);">Maria — COO</span>
              <span class="tag tag-warn">In Room</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px;">
              <span style="color:var(--text-muted);">Peter K. — CIO</span>
              <span class="tag"
                style="background:var(--surface2); color:var(--text-dim); border:1px solid var(--border);">Not
                Met</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px;">
              <span style="color:var(--text-muted);">Sarah L. — CDO</span>
              <span class="tag"
                style="background:var(--surface2); color:var(--text-dim); border:1px solid var(--border);">Not
                Met</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px;">
              <span style="color:var(--text-muted);">CFO (unnamed)</span>
              <span class="tag"
                style="background:var(--surface2); color:var(--text-dim); border:1px solid var(--border);">Unknown</span>
            </div>
          </div>

          <div
            style="margin-top:20px; padding:12px; background:var(--surface2); border-radius:var(--radius-sm); border:1px solid var(--border);">
            <div style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-muted); margin-bottom:6px;">
              THRESHOLD ALERT</div>
            <div style="font-size:12px; color:var(--text); line-height:1.5;">Ti at <span
                style="color:var(--accent);">72</span>. Reach <span style="color:var(--accent);">80</span> to unlock:
              request formal pitch slot or introduce additional stakeholders.</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ====== PAGE: FEEDBACK ====== -->
  <div class="page" id="page-feedback">
    <div class="phase-header">
      <div>
        <div class="phase-label">PHASE 03 — DEBRIEF</div>
        <div class="phase-title">Feedback Coach</div>
      </div>
      <div style="display:flex; gap:10px;">
        <button class="btn btn-secondary">Download Report</button>
        <button class="btn btn-primary" onclick="showPage('sim')">Retry Session →</button>
      </div>
    </div>

    <div class="feedback-layout">
      <!-- LEFT -->
      <div>
        <!-- Score Card -->
        <div class="score-card">
          <div class="score-header">
            <div>
              <div class="score-big" style="color: var(--warn);">74</div>
              <div class="score-grade">OVERALL READINESS SCORE</div>
            </div>
            <div class="result-badge breakthrough">⚡ THE BREAKTHROUGH — Ti peaked at 82</div>
          </div>

          <!-- TI Timeline -->
          <div style="font-size:11px; font-family:'DM Mono',monospace; color:var(--text-muted); margin-bottom:8px;">
            TRUST INDEX TIMELINE</div>
          <div class="ti-timeline">
            <svg class="ti-sparkline" viewBox="0 0 100 60" preserveAspectRatio="none">
              <defs>
                <linearGradient id="spark-grad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="var(--accent)" stop-opacity="0.3" />
                  <stop offset="100%" stop-color="var(--accent)" stop-opacity="0" />
                </linearGradient>
              </defs>
              <path d="M0,30 L10,28 L20,20 L25,26 L35,18 L45,22 L55,10 L65,14 L70,22 L78,16 L85,18 L90,28 L100,24"
                fill="none" stroke="var(--accent)" stroke-width="1.5" />
              <path
                d="M0,30 L10,28 L20,20 L25,26 L35,18 L45,22 L55,10 L65,14 L70,22 L78,16 L85,18 L90,28 L100,24 L100,60 L0,60Z"
                fill="url(#spark-grad)" />
              <!-- Threshold line at 80 -->
              <line x1="0" y1="12" x2="100" y2="12" stroke="rgba(0,212,170,0.3)" stroke-width="0.5"
                stroke-dasharray="2,2" />
              <line x1="0" y1="36" x2="100" y2="36" stroke="rgba(255,77,109,0.3)" stroke-width="0.5"
                stroke-dasharray="2,2" />
            </svg>
            <div
              style="position:absolute; top:8px; right:12px; font-size:10px; font-family:'DM Mono',monospace; color:var(--accent); opacity:0.6;">
              80 — BREAKTHROUGH</div>
            <div
              style="position:absolute; bottom:8px; right:12px; font-size:10px; font-family:'DM Mono',monospace; color:var(--danger); opacity:0.6;">
              40 — CHURN</div>
          </div>

          <!-- Breakdown -->
          <div class="breakdown-grid">
            <div class="metric-block">
              <div class="metric-block-label">Mirroring & Empathy</div>
              <div class="metric-block-score good">68<span style="font-size:16px; font-weight:400;">/100</span></div>
              <div class="metric-block-bar">
                <div class="metric-block-fill good" style="width:68%"></div>
              </div>
            </div>
            <div class="metric-block">
              <div class="metric-block-label">Consultative Inquiry</div>
              <div class="metric-block-score ok">52<span style="font-size:16px; font-weight:400;">/100</span></div>
              <div class="metric-block-bar">
                <div class="metric-block-fill ok" style="width:52%"></div>
              </div>
            </div>
            <div class="metric-block">
              <div class="metric-block-label">Factual Assurances</div>
              <div class="metric-block-score good">80<span style="font-size:16px; font-weight:400;">/100</span></div>
              <div class="metric-block-bar">
                <div class="metric-block-fill good" style="width:80%"></div>
              </div>
            </div>
            <div class="metric-block">
              <div class="metric-block-label">Solution Fit Relevance</div>
              <div class="metric-block-score bad">44<span style="font-size:16px; font-weight:400;">/100</span></div>
              <div class="metric-block-bar">
                <div class="metric-block-fill bad" style="width:44%"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- REDO CARDS -->
        <div class="section-title">Dialogue Redo Suggestions</div>
        <p class="section-sub">Specific turns where the Trust Index dropped — and how to handle them better.</p>

        <div class="redo-card">
          <div style="padding:12px 20px; background:var(--surface2); border-bottom:1px solid var(--border);">
            <span style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim);">TURN 4 · TI DROPPED
              −8</span>
          </div>
          <div class="redo-original">
            <div class="redo-label bad">✗ WHAT YOU SAID</div>
            <div class="redo-text">"EXL has a full end-to-end suite that covers PAS modernization, analytics, and
              customer servicing — let me walk you through our platform."</div>
          </div>
          <div style="padding:10px 20px; background:var(--surface2); font-size:11px; color:var(--text-dim);">⚠ Premature
            pitch. Maria hadn't confirmed her priority yet. This felt like a product demo, not a discovery conversation.
          </div>
          <div class="redo-better">
            <div class="redo-label good">✓ BETTER APPROACH</div>
            <div class="redo-text">"Before I go into capabilities — when your CEO talks about reducing cost-to-serve,
              which operational area does he anchor on first? Is it the advisor productivity side or the customer
              contact volumes?"</div>
          </div>
        </div>

        <div class="redo-card">
          <div style="padding:12px 20px; background:var(--surface2); border-bottom:1px solid var(--border);">
            <span style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim);">TURN 7 · MISSED
              OPPORTUNITY</span>
          </div>
          <div class="redo-original">
            <div class="redo-label bad">✗ WHAT YOU SAID</div>
            <div class="redo-text">"We've seen similar situations and EXL is well-positioned to help with the
              integration challenges you're describing."</div>
          </div>
          <div style="padding:10px 20px; background:var(--surface2); font-size:11px; color:var(--text-dim);">⚠ Too
            vague. Maria is skeptical — she needs specificity. A named reference would have spiked trust here.</div>
          <div class="redo-better">
            <div class="redo-label good">✓ BETTER APPROACH</div>
            <div class="redo-text">"A Tier-1 EU life insurer we work with had almost exactly this pattern — four legacy
              PAS systems post-acquisition. We deployed a workflow orchestration layer between their systems and reduced
              advisor contact rate by 38% in 14 months, without touching any core policy system."</div>
          </div>
        </div>
      </div>

      <!-- RIGHT: COACH SUMMARY -->
      <div>
        <div
          style="background: var(--surface); border:1px solid var(--border); border-radius: var(--radius); padding:24px; margin-bottom:16px;">
          <div
            style="font-family:'DM Mono',monospace; font-size:11px; color:var(--text-muted); margin-bottom:16px; letter-spacing:0.1em;">
            AI COACH SUMMARY</div>
          <div style="font-size:14px; color: var(--text); line-height:1.8;">
            You opened well by <span style="color:var(--accent);">positioning EXL as a non-disruptive partner</span> —
            the coexistence framing resonated with Maria and lifted Ti +6 immediately. Your Layer 2 question on advisor
            contact routing was strong and showed genuine discovery instinct.<br><br>
            Where you lost ground: <span style="color:var(--warn);">Turn 4 felt like a pivot to demo mode</span> before
            earning the right to pitch. Maria's skepticism was still active. The recovery was solid but the dip cost you
            8 Ti points.<br><br>
            Key unlock you missed: <span style="color:var(--danger);">CDO thread.</span> Maria mentioned "unified data"
            twice — this was an entry point to explore whether there's a CDO-level mandate running in parallel. That
            could have opened a second buying center.
          </div>
        </div>

        <div
          style="background: var(--surface); border:1px solid var(--border); border-radius: var(--radius); padding:24px; margin-bottom:16px;">
          <div
            style="font-family:'DM Mono',monospace; font-size:11px; color:var(--text-muted); margin-bottom:16px; letter-spacing:0.1em;">
            WHAT TO PRACTICE NEXT</div>
          <div style="display:flex; flex-direction:column; gap:12px;">
            <div style="display:flex; align-items:flex-start; gap:12px; font-size:13px;">
              <span style="color:var(--accent); font-size:18px; flex-shrink:0; line-height:1;">→</span>
              <span style="color:var(--text-muted);">Practice multi-stakeholder mapping — ask about the CDO and CIO
                before the first meeting ends</span>
            </div>
            <div style="display:flex; align-items:flex-start; gap:12px; font-size:13px;">
              <span style="color:var(--accent); font-size:18px; flex-shrink:0; line-height:1;">→</span>
              <span style="color:var(--text-muted);">Memorize 2 named reference stories for COO conversations in
                insurance</span>
            </div>
            <div style="display:flex; align-items:flex-start; gap:12px; font-size:13px;">
              <span style="color:var(--accent); font-size:18px; flex-shrink:0; line-height:1;">→</span>
              <span style="color:var(--text-muted);">Run Scenario 4: Skeptical CFO with IFRS 17 mandate — similar
                structure, different stakeholder</span>
            </div>
          </div>
        </div>

        <div
          style="background: var(--surface); border:1px solid var(--border); border-radius: var(--radius); padding:24px;">
          <div
            style="font-family:'DM Mono',monospace; font-size:11px; color:var(--text-muted); margin-bottom:16px; letter-spacing:0.1em;">
            SESSION STATS</div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <div>
              <div style="font-size:11px; color:var(--text-muted);">Duration</div>
              <div style="font-family:'DM Mono',monospace; font-size:18px; color:var(--text); margin-top:4px;">23:41
              </div>
            </div>
            <div>
              <div style="font-size:11px; color:var(--text-muted);">Turns taken</div>
              <div style="font-family:'DM Mono',monospace; font-size:18px; color:var(--text); margin-top:4px;">14</div>
            </div>
            <div>
              <div style="font-size:11px; color:var(--text-muted);">Ti peak</div>
              <div style="font-family:'DM Mono',monospace; font-size:18px; color:var(--accent); margin-top:4px;">82
              </div>
            </div>
            <div>
              <div style="font-size:11px; color:var(--text-muted);">Ti lowest</div>
              <div style="font-family:'DM Mono',monospace; font-size:18px; color:var(--warn); margin-top:4px;">58</div>
            </div>
            <div>
              <div style="font-size:11px; color:var(--text-muted);">Pain pts found</div>
              <div style="font-family:'DM Mono',monospace; font-size:18px; color:var(--text); margin-top:4px;">1 / 4
              </div>
            </div>
            <div>
              <div style="font-size:11px; color:var(--text-muted);">Case studies cited</div>
              <div style="font-family:'DM Mono',monospace; font-size:18px; color:var(--text); margin-top:4px;">2</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ====== PAGE: ANALYTICS ====== -->
  <div class="page" id="page-analytics">
    <div class="phase-header">
      <div>
        <div class="phase-label">PHASE 04 — TRACKING</div>
        <div class="phase-title">Analytics & Certifications</div>
      </div>
      <div style="display:flex; gap:10px; align-items:center;">
        <select
          style="background:var(--surface2); border:1px solid var(--border-bright); border-radius:var(--radius-sm); color:var(--text); font-size:13px; padding:8px 14px; outline:none;">
          <option>Insurance L&A · All Users</option>
          <option>Insurance P&C</option>
          <option>Healthcare</option>
        </select>
        <button class="btn btn-secondary">Export CSV</button>
      </div>
    </div>

    <!-- STAT CARDS -->
    <div class="analytics-grid">
      <div class="stat-card">
        <div class="stat-label">TEAM READINESS SCORE</div>
        <div class="stat-value">73<span style="font-size:18px; font-weight:400; color:var(--text-muted);">/100</span>
        </div>
        <div class="stat-delta up">↑ +8 vs last month</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">SESSIONS COMPLETED</div>
        <div class="stat-value">1,248</div>
        <div class="stat-delta up">↑ 34% this month</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">AVG TRUST INDEX PEAK</div>
        <div class="stat-value" style="color:var(--warn);">69</div>
        <div class="stat-delta up">↑ +5 pts · 3 months</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">CLOSE RATE (Ti=100)</div>
        <div class="stat-value" style="color:var(--accent);">12%</div>
        <div class="stat-delta up">↑ from 7% baseline</div>
      </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 400px; gap:24px;">
      <div>
        <!-- LEADERBOARD -->
        <div class="leaderboard mb-24">
          <div class="lb-header">
            <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:15px;">Team Leaderboard · Insurance
              L&A</div>
            <span class="tag tag-blue">This Month</span>
          </div>
          <div class="lb-row" style="background:var(--surface2); border-bottom:1px solid var(--border);">
            <div style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim);">#</div>
            <div style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim);">NAME</div>
            <div style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim); text-align:center;">
              SCORE</div>
            <div style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim); text-align:center;">TI
              PEAK</div>
            <div style="font-size:10px; font-family:'DM Mono',monospace; color:var(--text-dim); text-align:center;">
              SESSIONS</div>
          </div>
          <div class="lb-row">
            <div class="lb-rank top">1</div>
            <div class="lb-name">Priya Sharma</div>
            <div class="lb-score" style="color:var(--accent);">91</div>
            <div class="lb-score" style="color:var(--accent);">96</div>
            <div class="lb-score">18</div>
          </div>
          <div class="lb-row">
            <div class="lb-rank top">2</div>
            <div class="lb-name">Tom Hendricks</div>
            <div class="lb-score">88</div>
            <div class="lb-score">91</div>
            <div class="lb-score">14</div>
          </div>
          <div class="lb-row me">
            <div class="lb-rank">3</div>
            <div class="lb-name" style="display:flex; align-items:center; gap:8px;">Rahul S. <span
                class="lb-me-label">YOU</span></div>
            <div class="lb-score" style="color:var(--warn);">74</div>
            <div class="lb-score" style="color:var(--warn);">82</div>
            <div class="lb-score">9</div>
          </div>
          <div class="lb-row">
            <div class="lb-rank">4</div>
            <div class="lb-name">Sara Novak</div>
            <div class="lb-score">71</div>
            <div class="lb-score">79</div>
            <div class="lb-score">11</div>
          </div>
          <div class="lb-row">
            <div class="lb-rank">5</div>
            <div class="lb-name">James Okonkwo</div>
            <div class="lb-score">68</div>
            <div class="lb-score">76</div>
            <div class="lb-score">7</div>
          </div>
          <div class="lb-row">
            <div class="lb-rank">6</div>
            <div class="lb-name">Elena Marchetti</div>
            <div class="lb-score">64</div>
            <div class="lb-score">71</div>
            <div class="lb-score">6</div>
          </div>
        </div>

        <!-- SKILL GAPS -->
        <div
          style="background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:24px;">
          <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:15px; margin-bottom:16px;">Team Skill
            Gap Analysis</div>
          <div style="display:flex; flex-direction:column; gap:10px;">
            <div class="metric-row">
              <div class="metric-name" style="font-size:13px; min-width:180px;">Consultative Inquiry</div>
              <div class="metric-bar-mini" style="height:5px;">
                <div class="metric-bar-inner" style="width:48%; background:var(--danger);"></div>
              </div>
              <div class="metric-pct" style="color:var(--danger);">48%</div>
            </div>
            <div class="metric-row">
              <div class="metric-name" style="font-size:13px; min-width:180px;">Multi-stakeholder Mapping</div>
              <div class="metric-bar-mini" style="height:5px;">
                <div class="metric-bar-inner" style="width:52%; background:var(--warn);"></div>
              </div>
              <div class="metric-pct" style="color:var(--warn);">52%</div>
            </div>
            <div class="metric-row">
              <div class="metric-name" style="font-size:13px; min-width:180px;">Mirroring & Empathy</div>
              <div class="metric-bar-mini" style="height:5px;">
                <div class="metric-bar-inner" style="width:66%; background:var(--accent2);"></div>
              </div>
              <div class="metric-pct" style="color:var(--accent2);">66%</div>
            </div>
            <div class="metric-row">
              <div class="metric-name" style="font-size:13px; min-width:180px;">Case Study Recall</div>
              <div class="metric-bar-mini" style="height:5px;">
                <div class="metric-bar-inner" style="width:74%; background:var(--accent);"></div>
              </div>
              <div class="metric-pct" style="color:var(--accent);">74%</div>
            </div>
            <div class="metric-row">
              <div class="metric-name" style="font-size:13px; min-width:180px;">IFRS 17 Compliance Facts</div>
              <div class="metric-bar-mini" style="height:5px;">
                <div class="metric-bar-inner" style="width:80%; background:var(--accent);"></div>
              </div>
              <div class="metric-pct" style="color:var(--accent);">80%</div>
            </div>
          </div>
        </div>
      </div>

      <!-- CERTIFICATIONS -->
      <div>
        <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:15px; margin-bottom:16px;">Your
          Certifications</div>
        <div class="cert-grid">
          <div class="cert-card earned">
            <div class="cert-icon earned">🎯</div>
            <div class="cert-name">L&A Foundations</div>
            <div class="cert-desc">Passed the PMF quiz with 85+</div>
            <span class="tag tag-green">Earned</span>
          </div>
          <div class="cert-card earned">
            <div class="cert-icon earned">⚡</div>
            <div class="cert-name">Breakthrough Seller</div>
            <div class="cert-desc">Reached Ti > 80 in a live session</div>
            <span class="tag tag-green">Earned</span>
          </div>
          <div class="cert-card">
            <div class="cert-icon locked">🏆</div>
            <div class="cert-name">The Closer</div>
            <div class="cert-desc">Achieve Ti = 100 in any session</div>
            <span class="tag"
              style="background:var(--surface2); color:var(--text-dim); border:1px solid var(--border);">Locked</span>
          </div>
          <div class="cert-card">
            <div class="cert-icon locked">🔍</div>
            <div class="cert-name">Discovery Master</div>
            <div class="cert-desc">Uncover all 4 hidden pain points</div>
            <span class="tag"
              style="background:var(--surface2); color:var(--text-dim); border:1px solid var(--border);">Locked</span>
          </div>
          <div class="cert-card">
            <div class="cert-icon locked">🧠</div>
            <div class="cert-name">IFRS 17 Expert</div>
            <div class="cert-desc">Score 90+ in CFO scenario</div>
            <span class="tag"
              style="background:var(--surface2); color:var(--text-dim); border:1px solid var(--border);">Locked</span>
          </div>
          <div class="cert-card">
            <div class="cert-icon locked">🌐</div>
            <div class="cert-name">Multi-IMU Ready</div>
            <div class="cert-desc">Complete all 5 IMU certifications</div>
            <span class="tag"
              style="background:var(--surface2); color:var(--text-dim); border:1px solid var(--border);">Locked</span>
          </div>
        </div>

        <div
          style="background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:24px; margin-top:20px;">
          <div
            style="font-family:'DM Mono',monospace; font-size:11px; color:var(--text-muted); margin-bottom:16px; letter-spacing:0.1em;">
            YOUR PROGRESS</div>
          <div style="display:flex; gap:24px; align-items:center;">
            <div style="position:relative; width:100px; height:100px; flex-shrink:0;">
              <svg class="radial-svg" width="100" height="100" viewBox="0 0 36 36">
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--border)" stroke-width="2" />
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--accent)" stroke-width="2"
                  stroke-dasharray="50 100" stroke-linecap="round" />
              </svg>
              <div class="radial-center">
                <div class="radial-num" style="color:var(--accent);">2</div>
                <div class="radial-sub">of 6 certs</div>
              </div>
            </div>
            <div style="flex:1;">
              <div style="font-size:13px; color:var(--text-muted); line-height:1.7;">Complete <strong
                  style="color:var(--text);">The Closer</strong> cert to qualify for the EXL Sales Excellence Badge —
                shared with your manager and CRM profile.</div>
              <div style="margin-top:12px;">
                <button class="btn btn-primary" style="font-size:12px; padding:8px 16px;"
                  onclick="showPage('sim')">Practice Now →</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function showPage(id) {
      document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.getElementById('page-' + id).classList.add('active');

      const idx = { onboard: 0, learn: 1, sim: 2, feedback: 3, analytics: 4 }[id];
      document.querySelectorAll('.tab-btn')[idx]?.classList.add('active');
    }

    function selectOpt(el) {
      document.querySelectorAll('.quiz-opt').forEach(o => {
        o.classList.remove('selected');
      });
      el.classList.add('selected');
    }

    let micActive = false;
    let isMuted = false;
    let coachOn = true;
    let callActive = false;
    let timerInterval = null;
    let callSeconds = 0;
    let clientSpeakTimeout = null;

    const transcriptLines = [
      "We've had three vendors in this year already telling us they can solve our PAS fragmentation. Honestly, I'm skeptical.",
      "The contact volume issue is what's killing us — our advisors are spending 40% of their time on manual status updates.",
      "That's fair. But what does your coexistence approach actually look like in practice? We have hard API limitations.",
      "I appreciate the case study reference. What timeline are we talking for the orchestration layer to show results?",
      "Our CDO has been asking the same questions separately — maybe there's a reason to bring them into this conversation.",
    ];

    const coachWhispers = [
      "💬 Try a Layer 2 question — ask what's driving the advisor contact issue specifically.",
      "💬 She hinted at API limits — this opens the EXL integration layer story.",
      "💬 Cite the EU insurer case: 38% reduction in advisor contact rate, 14 months.",
      "💬 Ask about the CDO's mandate — shadow IT proliferation is a second pain point.",
      "💬 Ti at 72 — one strong consultative question should reach 80.",
    ];

    const tiDeltas = [
      { delta: +6, label: 'Coexistence framing resonated', dir: 'up' },
      { delta: +8, label: 'Layer 2 question · breakthrough approaching', dir: 'up' },
      { delta: -4, label: 'Premature pitch detected', dir: 'down' },
      { delta: +10, label: 'Case study cited with specifics', dir: 'up' },
      { delta: +5, label: 'Stakeholder expansion suggested', dir: 'up' },
    ];

    let transcriptIdx = 0;
    let tiCurrent = 72;
    let turnCount = 0;

    function startCall() {
      document.getElementById('call-stage-pre').style.display = 'none';
      document.getElementById('call-stage-active').style.display = 'flex';
      callActive = true;
      startTimer();
      // Begin first client turn after a moment
      setTimeout(() => clientSpeak(), 1200);
    }

    function startTimer() {
      callSeconds = 252; // 04:12 demo start
      timerInterval = setInterval(() => {
        callSeconds++;
        const m = String(Math.floor(callSeconds / 60)).padStart(2, '0');
        const s = String(callSeconds % 60).padStart(2, '0');
        const el = document.getElementById('call-timer');
        if (el) el.textContent = '⏱ ' + m + ':' + s;
      }, 1000);
    }

    function clientSpeak() {
      if (!callActive) return;
      const ring1 = document.getElementById('ring1');
      const ring2 = document.getElementById('ring2');
      const badge = document.getElementById('speaking-badge');
      const waveform = document.getElementById('client-waveform');
      const transcript = document.getElementById('transcript-text');

      ring1.classList.add('ring-active');
      ring2.classList.add('ring2-active');
      badge.style.opacity = '1';
      waveform.style.opacity = '1';

      const line = transcriptLines[transcriptIdx % transcriptLines.length];
      let chars = 0;
      transcript.style.fontStyle = 'normal';
      transcript.style.color = 'var(--text)';
      transcript.textContent = '';

      const typeInterval = setInterval(() => {
        transcript.textContent = line.slice(0, chars++);
        if (chars > line.length) {
          clearInterval(typeInterval);
          setTimeout(() => {
            ring1.classList.remove('ring-active');
            ring2.classList.remove('ring2-active');
            badge.style.opacity = '0';
            waveform.style.opacity = '0';
            // Prompt user to respond
            document.getElementById('mic-status-label').textContent = 'YOUR MIC · YOUR TURN';
            document.getElementById('mic-btn').classList.add('active-mic');
            micActive = true;
            updateUserWave(true);
            // Update coach whisper
            const wh = document.getElementById('coach-whisper');
            if (wh && coachOn) wh.textContent = coachWhispers[transcriptIdx % coachWhispers.length];
            transcriptIdx++;
          }, 800);
        }
      }, 38);
    }

    function toggleMic() {
      if (!callActive) return;
      micActive = !micActive;
      const btn = document.getElementById('mic-btn');
      if (micActive) {
        btn.classList.add('active-mic');
        btn.classList.remove('muted-mic');
        document.getElementById('mic-status-label').textContent = 'YOUR MIC · SPEAKING';
        updateUserWave(true);
        // Simulate finishing speech after 4s
        clearTimeout(clientSpeakTimeout);
        clientSpeakTimeout = setTimeout(() => {
          finishUserTurn();
        }, 4000);
      } else {
        btn.classList.remove('active-mic');
        updateUserWave(false);
        document.getElementById('mic-status-label').textContent = 'YOUR MIC · PAUSED';
      }
    }

    function finishUserTurn() {
      if (!callActive) return;
      const btn = document.getElementById('mic-btn');
      btn.classList.remove('active-mic');
      micActive = false;
      updateUserWave(false);
      document.getElementById('mic-status-label').textContent = 'YOUR MIC · LISTENING';

      // Apply Ti delta
      const delta = tiDeltas[turnCount % tiDeltas.length];
      tiCurrent = Math.max(20, Math.min(100, tiCurrent + delta.delta));
      updateTI(tiCurrent, delta);
      turnCount++;

      // Client responds after pause
      setTimeout(() => {
        document.getElementById('transcript-text').textContent = '';
        document.getElementById('transcript-text').style.fontStyle = 'italic';
        document.getElementById('transcript-text').style.color = 'var(--text-muted)';
        document.getElementById('transcript-text').textContent = 'Thinking...';
        setTimeout(() => clientSpeak(), 1200);
      }, 600);
    }

    function updateTI(val, delta) {
      const tiValEl = document.getElementById('ti-val');
      const tiBarEl = document.getElementById('ti-bar');
      if (!tiValEl || !tiBarEl) return;

      tiValEl.textContent = val;
      tiBarEl.style.width = val + '%';

      const cls = val >= 80 ? 'high' : val >= 40 ? 'mid' : 'low';
      tiValEl.className = 'ti-value ' + cls;
      tiBarEl.className = 'ti-bar-fill ' + cls;

      // Add turn log entry
      const log = document.getElementById('turn-log');
      if (log && delta) {
        const entry = document.createElement('div');
        entry.className = 'ti-event';
        entry.style.fontSize = '11px';
        entry.innerHTML = `<span>Ti</span><span class="ti-delta ${delta.dir}">${delta.dir === 'up' ? '▲' : '▼'} ${delta.delta > 0 ? '+' : ''}${delta.delta} → ${val}</span><span style="color:var(--text-dim);">${delta.label}</span>`;
        log.appendChild(entry);
        log.scrollTop = log.scrollHeight;
      }

      // Breakthrough alert
      if (val >= 80) {
        const bar = document.getElementById('alert-bar-wrap');
        if (bar) bar.innerHTML = `<div class="alert-bar breakthrough" style="margin-bottom:0;"><span>🎯</span><span><strong>Breakthrough unlocked!</strong> You can now request a formal pitch or stakeholder meeting.</span></div>`;
      }
    }

    function updateUserWave(active) {
      document.querySelectorAll('.wave-bar.user').forEach(b => {
        if (isMuted || !active) {
          b.classList.add('idle');
        } else {
          b.classList.remove('idle');
        }
      });
    }

    function toggleMute() {
      isMuted = !isMuted;
      const btn = document.getElementById('mute-btn');
      if (isMuted) {
        btn.style.background = 'var(--danger-dim)';
        btn.style.borderColor = 'rgba(255,77,109,0.3)';
        document.getElementById('mic-btn').classList.add('muted-mic');
        document.getElementById('mic-btn').classList.remove('active-mic');
        document.querySelectorAll('.wave-bar.user').forEach(b => b.classList.add('muted'));
        document.getElementById('mic-status-label').textContent = 'YOUR MIC · MUTED';
      } else {
        btn.style.background = 'var(--surface2)';
        btn.style.borderColor = 'var(--border-bright)';
        document.getElementById('mic-btn').classList.remove('muted-mic');
        document.querySelectorAll('.wave-bar.user').forEach(b => b.classList.remove('muted'));
        document.getElementById('mic-status-label').textContent = 'YOUR MIC · LISTENING';
      }
    }

    function toggleCoach() {
      coachOn = !coachOn;
      const chip = document.getElementById('ai-coach-chip');
      const whisper = document.getElementById('coach-whisper');
      const btn = document.getElementById('coach-btn');
      if (coachOn) {
        chip.textContent = '🧠 Coach ON';
        chip.style.background = 'var(--warn-dim)';
        chip.style.color = 'var(--warn)';
        whisper.style.opacity = '1';
      } else {
        chip.textContent = '🧠 Coach OFF';
        chip.style.background = 'var(--surface2)';
        chip.style.color = 'var(--text-dim)';
        whisper.style.opacity = '0.3';
      }
    }

    function togglePause() {
      callActive = !callActive;
      const btn = event.target;
      btn.textContent = callActive ? '⏸ Pause' : '▶ Resume';
    }

    function endCall() {
      callActive = false;
      clearInterval(timerInterval);
      clearTimeout(clientSpeakTimeout);
      document.getElementById('call-stage-active').style.display = 'none';
      document.getElementById('call-stage-ended').style.display = 'flex';
    }

    function useQuickFrame(btn) {
      document.querySelectorAll('.qf-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const frameMap = {
        'Acknowledge pain': '💬 Mirror her exact language back — "40% on status updates is a significant ops cost."',
        'Ask Layer 2': '💬 "Is the advisor contact driven by data visibility gaps, or inbound query routing?"',
        'Cite case study': '💬 "Tier-1 EU insurer we work with reduced advisor contact rate 38% in 14 months."',
        'Coexistence angle': '💬 "We don\'t need to touch your PAS. The orchestration layer sits on top."'
      };
      const whisper = document.getElementById('coach-whisper');
      if (whisper) whisper.textContent = frameMap[btn.textContent] || '';
      setTimeout(() => btn.classList.remove('active'), 2000);
    }


  </script>
</body>

</html>