export function convertPixelsToRem(px) {
  // Gets font size of root element of the document
  const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);

  // console.log(px / rootFontSize);
  return px / rootFontSize;
}


export function convertRemToPixels(rem) {
  // Gets font size of root element of the document
  const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);

  // console.log(rem * rootFontSize);
  return rem * rootFontSize;
}


export function getViewport() {
  var w = Math.max(
    document.documentElement.clientWidth,
    window.innerWidth || 0
  );
  var h = Math.max(
    document.documentElement.clientHeight,
    window.innerHeight || 0
  );
  var dim = { width: w, height: h };
  return dim;
}


/**
 * watchAwaitSelector
 * * Uses mutation observer to watch for 'selector' involved in DOM changes (added, removed, class change, content change, etc)
 * @param {Function} callback A callback function to be run whenever DOM changes are detected, can be anonymous or named
 * @param {String} selector Element(s) to look for involved in DOM changes, you can watch multiple selectors by separating via comma '.class1, .class2, #id3'
 * @param {Node} rootNode Node to watch from, typically document
 * @param {Number} fallbackDelay Interval to be used if the browser does not support MutationObserver, value is in milliseconds (2000 = 2 seconds)
 */
export const awaitSelector = (selector, rootNode, fallbackDelay) => new Promise((resolve, reject) => {
  try {
    const root = rootNode || document
    const ObserverClass = MutationObserver || WebKitMutationObserver || null
    const mutationObserverSupported = typeof ObserverClass === 'function'
    let observer
    const stopWatching = () => {
      if (observer) {
        if (mutationObserverSupported) {
          observer.disconnect()
        } else {
          clearInterval(observer)
        }
        observer = null
      }
    }
    const findAndResolveElements = () => {
      const allElements = root.querySelectorAll(selector)
      if (allElements.length === 0) return
      const newElements = []
      const attributeForBypassing = 'data-awaitselector-resolved'
      allElements.forEach((el, i) => {
        if (typeof el[attributeForBypassing] === 'undefined') {
          allElements[i][attributeForBypassing] = ''
          newElements.push(allElements[i])
        }
      })
      if (newElements.length > 0) {
        stopWatching()
        resolve(newElements)
      }
    }
    if (mutationObserverSupported) {
      observer = new ObserverClass(mutationRecords => {
        const nodesWereAdded = mutationRecords.reduce(
          (found, record) => found || (record.addedNodes && record.addedNodes.length > 0),
          false
        )
        if (nodesWereAdded) {
          findAndResolveElements()
        }
      })
      observer.observe(root, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeOldValue: true,
        characterData: true,
        characterDataOldValue: true
      })
    } else {
      observer = setInterval(findAndResolveElements, fallbackDelay || 250)
    }
    findAndResolveElements()
  } catch (exception) {
    reject(exception)
  }
})

export const watchAwaitSelector = (callback, selector, rootNode, fallbackDelay) => {
  (function awaiter(continueWatching = true) {
    if (continueWatching === false) return
    awaitSelector(selector, rootNode, fallbackDelay)
      .then(callback)
      .then(awaiter)
  }())
}

export function throttle(type, name, obj) {
  var running = false;

  obj = obj || window;

  var func = function() {
    if (running) return;

    running = true;

    requestAnimationFrame(function() {
      obj.dispatchEvent(new CustomEvent(name));
      running = false;
    });
  };

   obj.addEventListener(type, func);
}

export function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
}

export function insertAfter(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}

export function removeClassFromAll(elements, className) {
  if(elements.length > 0) {
    for(let element of elements) {
      element.classList.remove(className);
    }
  }
}

/**
* Equalizes heights of elements, can be used with 
* a (throttled) resize event listener to replace Foundation Equalizer
* which calculates incorrectly / not at all in some instances
*
* @param target {String||NodeList||Array} either a selector string, or nodelist/array of elements to equalize
* @param resetBetween {Boolean} if true, removes any inline height styles set before equalizing
*/
export function equalHeights(target, resetBetween = true) {
  let elements;
  let tallest = 0;
  
  if(typeof(target) !== 'string') {
    elements = target;
  } else {
    elements = document.querySelectorAll(target);
  }
  
  if(resetBetween === true) {
    for(let i = 0; i < elements.length; i++) {
      let ele = elements[i];
      // Remove inline height (if any) so element returns to natural/styled height 
      ele.style.height = "";
    }
  }

  for(let i = 0; i < elements.length; i++) {
      let ele = elements[i];
      let eleHeight = ele.offsetHeight;
      tallest = (eleHeight>tallest ? eleHeight : tallest);
  }

  for(let i = 0; i < elements.length; i++) {
      elements[i].style.height = tallest + "px";
  }
}

export function equalWidths(selector) {
    let elements;
    let widest = 0;
    
    if(typeof(selector) !== 'string') {
      elements = selector;
    } else {
      elements = document.querySelectorAll(selector);
    }

    for(let i = 0; i < elements.length; i++) {
        let ele = elements[i];
        let eleWidth = ele.offsetWidth;
        widest = (eleWidth>widest ? eleWidth : widest);
    }

    for(let i = 0; i < elements.length; i++) {
        elements[i].style.width = widest + "px";
    }
}

export function setHeightAuto(selector) {
  var elements = document.querySelectorAll(selector);
  for(let e of elements) {
    e.style.height = "auto";
  }
}


/**
* Calculates number of items in a row, relative to a parent
*
* @param grid {Array} array of elements contained within a parent element
*/
export function getNumPerRow(grid) {
  const baseOffset = grid[0].offsetTop;
  const breakIndex = grid.findIndex(item => item.offsetTop > baseOffset);
  const numPerRow = (breakIndex === -1 ? grid.length : breakIndex);
  return numPerRow;
}


/**
* Returns an array with arrays of the given size.
*
* @param myArray {Array} array to split
* @param chunk_size {Integer} Size of every group
*/
export function chunkArray(myArray, chunk_size) {
   let index = 0;
   let arrayLength = myArray.length;
   let tempArray = [];
   
   for (index = 0; index < arrayLength; index += chunk_size) {
       let myChunk = myArray.slice(index, index+chunk_size);
       // Do something if you want with the group
       tempArray.push(myChunk);
   }

   return tempArray;
}