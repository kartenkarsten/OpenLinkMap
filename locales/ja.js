/*
OpenLinkMap Copyright (C) 2010 Alexander Matheisen
This program comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it under certain conditions.
See http://wiki.openstreetmap.org/wiki/OpenLinkMap for details.
*/

// translations of labels
var translations =
{
	"back" : "戻る",
	"details" : "詳細",
	"search" : "検索",
	"spam" : "マップエラーを報告",
	"title" : "Maps and data <a href=\"http://www.openstreetmap.org/copyright\">© OpenStreetMap contributors</a>.<br />陰影処理: <a href=\"http://nasa.gov/\">NASA SRTM</a>.",
	"info" : "追加情報",
	"contact" : "連絡先",
	"loading" : "ロード中...",
	"nothing" : "見つかりませんでした.",
	"nothingmore" : "結果はこれで全てです.",
	"update" : "最終更新:",
	"showMarker" : "ズームしてマーカーを表示",
	"empty" : "空の入力.",
	"more" : "さらに詳細",
	"moreresults" : "さらに結果を...",
	"less" : "未満",
	"hide" : "隠す",
	"show" : "表示",
	"permalink" : "パーマリンク",
	"finish" : "終了",
	"markerLoading" : "ポイントをロード中...",
	"hillshading" : "陰影処理",
	"object" : "POIの詳細",
	"marker" : "マーカー",
	"searchresults" : "検索結果",
	"routing" : "ルート",
	"searchoption" : "現在のマップビュー内のみを検索",
	"close" : "クリックして閉じる",
	"ad" : "Iデータを改善しよう! Keepright からの新しいウェブサイトチェッカーで間違ったリンクを修正しよう!",
	"inolm" : "OpenLinkMap 内に表示...",
	"embed" : "HTML コード",
	"embeddescription" : "このHTMLコードをコピーして、マーカー付きの小さな地図をあなたのウェブサイトに表示.",
	"embedattribution" : "Maps and data <a href=\"http://www.openstreetmap.org/copyright\">© OpenStreetMap contributors</a>.<br />陰影処理: <a href=\"http://nasa.gov/\">NASA SRTM</a>."
};

// descriptions for search results
var descriptions =
{
	"city" : "#county#, #state#, #country#",
	"country" : "",
	"county" : "#state#, #country#",
	"footway" : "#city#, #county#, #country#",
	"hamlet" : "#county#, #country#",
	"house_number" : "#city#, #county#, #country#",
	"island" : "#state#, #country#",
	"isolated_dwelling" : "#county#, #state#, #country#",
	"locality" : "#county#, #state#, #country#",
	"place" : "#county#, #state#, #country#",
	"postcode" : "#county#, #state#, #country#",
	"region" : "#country#",
	"road" : "#city#, #county#, #country#",
	"state" : "#country#",
	"state_district" : "#state#, #country#",
	"suburb" : "#city#, #county#, #country#",
	"town" : "#state#, #country#",
	"village" : "#county#, #country#",
	"poi" : "#footway# #road# #house_number#, #postcode# #village# #city#, #country#",
	"name" : "#footway# #road# #house_number#"
};

// translations of OpenLayers
OpenLayers.Lang.en =
{
	'unhandledRequest': "ハンドルできないリクエストがリターンされました ${statusText}",
	'Permalink': "パーマリンク",
	'Overlays': "オーバーレイ",
	'Base Layer': "ベースレイヤー",
	'sameProjection': "概要マップはメインのマップと同じ投影法内にある時だけ動作します",
	'readNotImplemented': "読込は未実装.",
	'writeNotImplemented': "書込は未実装.",
	'noFID': "FID が無いため、フィーチャーを更新できません.",
	'errorLoadingGML': "GML ファイル ${url} をロード中にエラー",
	'browserNotSupported': "あなたのブラウザはベクターレンダリングをサポートしていません. 現在サポートしているレンダラーは次の通り:\n${renderers}",
	'componentShouldBe': "addFeatures : コンポーネントは ${geomType}でなければなりません",
	'getFeatureError':
		"getFeatureFromEvent がレンダラーの無いレイヤーで呼び出されました. これは通常" +
		"レイヤーを破壊したが、関連するハンドラーがいくつか残っている、というような場合に起こります.",
	'minZoomLevelError':
		"minZoomLevel プロパティはFixedZoomLevels-descendent" +
		"レイヤー以外で使用されることは想定されていません. このため" +
		"このminZoomLevel 用のwfs レイヤーチェックは過去の遺物" +
		"です. しかしながらこれを使っている可能性のあるOLベースの" +
		"アプリケーションがあることを考えずに削除する訳には行きません." +
		" 従って我々はこれを非推奨とします -- 下記minZoomLevel" +
		"チェックは3.0で削除予定です. 代わりに、こちらにあるように" +
		"min/max 解像度設定を使ってください: " +
		"http://trac.openlayers.org/wiki/SettingZoomLevels",
	'commitSuccess': "WFS トランザクション: 成功 ${response}",
	'commitFailed': "WFS トランザクション: 失敗 ${response}",
	'googleWarning':
		"Googleレイヤーが正しくロードできませんでした.<br><br>" +
		"このメッセージを解消するには,右上隅にあるレイヤー" +
		"スイッチャーで新しいベースレイヤーを選んでください.<br><br>" +
		"多くの場合、これはGoogle Mapsライブラリのスクリプトが" +
		"includeされていないか,あなたのサイトの正しいAPIキーが" +
		"含まれていないことによります.<br><br>" +
		"開発者向け: 正しく動作させるためのヘルプは, " +
		"<a href='http://trac.openlayers.org/wiki/Google' " +
		"target='_blank'>こちらをクリック</a>",
	'getLayerWarning':
		"${layerType} レイヤーが正しくロードできませんでした.<br><br>" +
		"このメッセージを解消するには,右上隅にあるレイヤー" +
		"スイッチャーで新しいベースレイヤーを選んでください.<br><br>" +
		"多くの場合、これは ${layerLib} ライブラリのスクリプトが" +
		"正しくincludeされていないことによります.<br><br>" +
		"開発者向け: 正しく動作させるためのヘルプは, " +
		"<a href='http://trac.openlayers.org/wiki/${layerLib}' " +
		"target='_blank'>こちらをクリック</a>",
		'Scale = 1 : ${scaleDenom}': "Scale = 1 : ${scaleDenom}",
	'W': '西',
	'E': '東',
	'N': '北',
	'S': '南',
	'graticule': '経緯線網',
	'layerAlreadyAdded': "マップにレイヤー ${layerName} が追加されようとしましたが、既に存在しています",
	'reprojectDeprecated':
		"あなたは ${layerName} レイヤー上の'reproject' オプションを" +
		"使っています. このオプションは非推奨です: " +
		"これは商用ベースマップ上へのデータ表示をサポートする" +
		"ために設計されましたが,この機能は今ではSpherical Mercatorサポート" +
		"を使えば実現できます. より詳細な情報は次のURLを参照 " +
		"http://trac.openlayers.org/wiki/SphericalMercator.",
	'methodDeprecated':
		"このメソッドは非推奨で3.0で削除予定です. " +
		"代わりに ${newMethod} を使ってください.",
	'boundsAddError': "追加機能に x と y の値を渡さなければなりません.",
	'lonlatAddError': "追加機能に lon とlat の値を渡さなければなりません..",
	'pixelAddError': "追加機能に x と y の値を渡さなければなりません..",
	'unsupportedGeometryType': "サポートされないジオメトリ種別: ${geomType}",
	'pagePositionFailed': "OpenLayers.Util.pagePosition 失敗: id ${elemId} のエレメントの配置が誤っている可能性があります.",
	'filterEvaluateNotImplemented': "このフィルタ種別には評価は実装されていません.",
	'end': '',
	'proxyNeeded': " ${url}にアクセスするには、あなたはおそらくOpenLayers.ProxyHost  をセットする必要があります."+
	"http://trac.osgeo.org/openlayers/wiki/FrequentlyAskedQuestions#ProxyHost 参照",
};